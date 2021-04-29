let preview = {
  // default values
  defaults: {
    font: "monospace",
    color: "36BCF7",
    size: "20",
    center: "false",
    multiline: "false",
    width: "400",
    height: "50"
  },
  dummyText: [
    "The five boxing wizards jump quickly",
    "How vexingly quick daft zebras jump",
    "Quick fox jumps nightly above wizard",
    "Sphinx of black quartz, judge my vow",
    "Waltz, bad nymph, for quick jigs vex",
    "Glib jocks quiz nymph to vex dwarf",
    "Jived fox nymph grabs quick waltz",
  ],
  // update the preview
  update: function () {
    const copyButton = document.querySelector(".copy-button");
    // get parameter values from all .param elements
    const params = Array.from(document.querySelectorAll(".param:not([data-index])")).reduce(
      (acc, next) => {
        // copy accumulator into local object
        let obj = acc;
        let value = next.value;
        // remove hash from any colors and remove "FF" if full opacity
        value = value.replace(/#([A-Fa-f0-9]{6})(F|f){2}$/, "$1");
        // add value to reduction accumulator
        obj[next.id] = value;
        return obj;
      }, {}
    );
    const lineInputs = Array.from(document.querySelectorAll(".param[data-index]"));
    // disable copy button if any line contains semicolon
    if (lineInputs.some((el) => el.value.indexOf(";") >= 0)) {
      return copyButton.disabled = "true";
    }
    // add lines to parameters
    params.lines = lineInputs
      .map((el) => el.value) // get values
      .filter((val) => val.length) // skip blank entries
      .join(";"); // join lines with ';' delimiter
    // function to URI encode string but keep semicolons as ';' and spaces as '+'
    const encode = (str) => {
      return encodeURIComponent(str).replace(/%3B/g, ";").replace(/%20/g, "+")
    };
    // convert parameters to query string
    const query = Object.keys(params)
      .filter((key) => params[key] !== this.defaults[key]) // skip if default value
      .map((key) => encode(key) + "=" + encode(params[key])) // encode keys and values
      .join("&"); // join lines with '&' delimiter
    // generate links and markdown
    const imageURL = `${window.location.origin}?${query}`;
    const demoImageURL = `/?${query}`;
    const repoLink = "https://git.io/typing-svg";
    const md = `[![Typing SVG](${imageURL})](${repoLink})`;
    // don't update if nothing has changed
    const mdElement = document.querySelector(".md code");
    const image = document.querySelector(".output img");
    if (mdElement.innerText === md) {
      return;
    }
    // update image preview
    image.src = demoImageURL;
    image.classList.add("loading");
    // update markdown
    mdElement.innerText = md;
    // disable copy button if no lines are filled in
    copyButton.disabled = !params.lines.length;
  },
  addLine: function () {
    const parent = document.querySelector(".lines");
    const index = parent.querySelectorAll("input").length + 1;
    // label
    const label = document.createElement("label");
    label.innerText = `Line ${index}`;
    label.setAttribute("for", `line-${index}`);
    label.dataset.index = index;
    // line input box
    const input = document.createElement("input");
    input.className = "param";
    input.type = "text";
    input.id = `line-${index}`;
    input.name = `line-${index}`;
    input.placeholder = "Enter text here";
    input.value = this.dummyText[(index - 1) % this.dummyText.length];
    input.pattern = "^[^;]*$";
    input.title = "Text cannot contain semicolons";
    input.dataset.index = index;
    // removal button
    const deleteButton = document.createElement("button");
    deleteButton.className = "delete-line btn";
    deleteButton.setAttribute(
      "onclick",
      "return preview.removeLine(this.dataset.index);"
    );
    deleteButton.innerHTML = '<svg stroke="currentColor" fill="currentColor"  stroke-width="0" viewBox="0 0 1024 1024" height="0.85em" width="0.85em" xmlns="http://www.w3.org/2000/svg"> <path d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z"> </path> </svg>';
    deleteButton.dataset.index = index;

    // add elements
    parent.appendChild(label);
    parent.appendChild(input);
    parent.appendChild(deleteButton);

    // disable button if only 1
    parent.querySelector(".delete-line.btn").disabled = index == 1;

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
    const labels = parent.querySelectorAll("label");
    labels
      .forEach((label) => {
        const labelIndex = Number(label.dataset.index);
        if (labelIndex > index) {
          label.dataset.index = labelIndex - 1;
          label.setAttribute("for", `line-${labelIndex - 1}`);
          label.innerText = `Line ${labelIndex - 1}`;
        }
      });
    const inputs = parent.querySelectorAll(".param");
    inputs
      .forEach((input) => {
        const inputIndex = Number(input.dataset.index);
        if (inputIndex > index) {
          input.dataset.index = inputIndex - 1;
          input.setAttribute("id", `line-${inputIndex - 1}`);
          input.setAttribute("name", `line-${inputIndex - 1}`);
        }
      });
    const buttons = parent.querySelectorAll(".delete-line.btn");
    buttons
      .forEach((button) => {
        const buttonIndex = Number(button.dataset.index);
        if (buttonIndex > index) {
          button.dataset.index = buttonIndex - 1;
        }
      });
    // disable button if only 1
    buttons[0].disabled = buttons.length == 1;
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

// checkbox listener
document.querySelector(".show-border input").addEventListener("change", function () {
  const img = document.querySelector(".output img");
  this.checked ? img.classList.add("outlined") : img.classList.remove("outlined");
});

// when the page loads
window.addEventListener(
  "load",
  () => {
    // add first line
    preview.addLine();
    preview.update();
  },
  false
);