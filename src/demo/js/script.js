let preview = {
  // default values
  defaults: {
    theme: "default",
    hide_border: "false",
  },
  // update the preview
  update: function () {
    // get parameter values from all .param elements
    const params = Array.from(document.querySelectorAll(".param")).reduce(
      (acc, next) => {
        let obj = {
          ...acc
        };
        let value = next.value;

        if (value.indexOf('#') >= 0) {
          // if the value is colour, remove the hash sign
          value = value.replace(/#/g, "");
          if (value.length > 6) {
            // if the value is in hexa and opacity is 1, remove FF
            value = value.replace(/(F|f){2}$/, "");
          }
        }
        obj[next.id] = value;
        return obj;
      }, {}
    );
    // convert parameters to query string
    const encode = encodeURIComponent;
    const query = Object.keys(params)
      .filter((key) => params[key] !== this.defaults[key])
      .map((key) => encode(key) + "=" + encode(params[key]))
      .join("&");
    // generate links and markdown
    const imageURL = `${window.location.origin}?${query}`;
    const demoImageURL = `preview.php?${query}`;
    const repoLink = "https://git.io/streak-stats";
    const md = `[![GitHub Streak](${imageURL})](${repoLink})`;
    // update image preview
    document.querySelector(".output img").src = demoImageURL;
    // update markdown
    document.querySelector(".md code").innerText = md;
    // disable copy button if username is invalid
    const copyButton = document.querySelector(".copy-button");
    copyButton.disabled = !!document.querySelectorAll("#user:invalid").length;
  },
  addLine: function () {
    const parent = document.querySelector(".lines");
    const index = parent.querySelectorAll("input").length + 1;
    // label
    const label = document.createElement("label");
    label.innerText = `Line ${index}`;
    label.setAttribute("for", `line-${index}`);
    label.dataset.index = index;
    // color picker
    const input = document.createElement("input");
    input.className = "param";
    input.type = "text";
    input.id = `line-${index}`;
    input.name = `line-${index}`;
    input.placeholder = "Enter text here";
    input.pattern = "^[^;]*$";
    input.title = "Text cannot contain semicolons";
    input.dataset.index = index;
    // removal button
    const xButton = document.createElement("button");
    xButton.className = "x btn";
    xButton.setAttribute(
      "onclick",
      "return preview.removeLine(this.dataset.index);"
    );
    xButton.innerText = "✕";
    xButton.dataset.index = index;
    // add elements
    parent.appendChild(label);
    parent.appendChild(input);
    parent.appendChild(xButton);

    // update and exit
    this.update();
    return false;
  },
  removeLine: function (index) {
    index = Number(index);
    const parent = document.querySelector(".lines");
    // remove all elements for given property
    parent
      .querySelectorAll(`[data-index="${index}"]`)
      .forEach((el) => {
        parent.removeChild(el);
      });
    // update index numbers
    parent
      .querySelectorAll(`label[data-index]`)
      .forEach((label) => {
        const labelIndex = Number(label.dataset.index);
        if (labelIndex > index) {
          label.dataset.index = labelIndex - 1;
          label.setAttribute("for", `line-${labelIndex - 1}`);
          label.innerText = `Line ${labelIndex - 1}`;
        }
      });
    parent
      .querySelectorAll(`input[data-index]`)
      .forEach((input) => {
        const inputIndex = Number(input.dataset.index);
        if (inputIndex > index) {
          input.dataset.index = inputIndex - 1;
          input.setAttribute("id", `line-${inputIndex - 1}`);
          input.setAttribute("name", `line-${inputIndex - 1}`);
        }
      });
    parent
      .querySelectorAll(`button[data-index]`)
      .forEach((button) => {
        const buttonIndex = Number(button.dataset.index);
        if (buttonIndex > index) {
          button.dataset.index = buttonIndex - 1;
        }
      });
    // update and exit
    this.update();
    return false;
  },
};

let clipboard = {
  copy: function (el) {
    // create input box to copy from
    const input = document.createElement("input");
    input.value = document.querySelector(".md code").innerText;
    document.body.appendChild(input);
    // select all
    input.select();
    input.setSelectionRange(0, 99999);
    // copy
    document.execCommand("copy");
    // remove input box
    input.parentElement.removeChild(input);
    // set tooltip text
    el.title = "Copied!";
  },
};

let tooltip = {
  reset: function (el) {
    // remove tooltip text
    el.removeAttribute("title");
  },
};

// refresh preview on interactions with the page
document.addEventListener("keyup", () => preview.update(), false);
document.addEventListener("click", () => preview.update(), false);

// when the page loads
window.addEventListener(
  "load",
  () => {
    // add first line
    preview.addLine();
  },
  false
);