# FAQ

## How do I include Readme Typing SVG in my Readme?

Markdown files on GitHub support embedded images using Markdown or HTML. You can customize your SVG on the [demo site](https://readme-typing-svg.demolab.com/demo/) and use the image source in either of the following ways:

### Markdown

```md
[![Typing SVG](https://readme-typing-svg.demolab.com/?lines=First+line+of+text;Second+line+of+text)](https://git.io/typing-svg "Typing SVG")
```

### HTML

<!-- prettier-ignore-start -->
```html
<a href="https://git.io/typing-svg" title=""Readme Typing SVG><img src="https://readme-typing-svg.demolab.com/?lines=First+line+of+text;Second+line+of+text"/></a>
```
<!-- prettier-ignore-end -->

## The text is getting cut off at the end, how do I fix it?

The text rendered within the SVG can be any variable width, therefore you must specify the width manually to ensure the text will fit.

The `width` parameter in the URL should be increased such that the full width of the text is displayed properly.

```md
https://readme-typing-svg.demolab.com/?lines=Your+Long+Message+With+A+Long+Width&width=460
```

## How do I center the image on the page?

To center align images, you must use the HTML syntax and wrap it in an element with the HTML attribute `align="center"`.

<!-- prettier-ignore-start -->
```html
<p align="center">
  <a href="https://git.io/typing-svg"><img src="https://readme-typing-svg.demolab.com/?lines=This+image+is+center-aligned&font=Fira%20Code&center=true&width=380&height=50"/></a>
</p>
```
<!-- prettier-ignore-end -->

## How do I add multiple spaces in the middle of a line?

Similar to HTML, SVG/XML treats multiple consecutive spaces as a single space.

A workaround for adding extra spaces can be to use other whitespace characters (for example, you can copy-paste the en-space or other unusual spaces from https://qwerty.dev/whitespace). The alternate whitespace characters don't get ignored.

## How do I make different SVGs for dark mode and light mode?

As of May 2022, you can now [specify theme context](https://github.blog/changelog/2022-05-19-specify-theme-context-for-images-in-markdown-beta/) using the `<picture>` and `<source>` elements as shown below. The dark mode version appears in the `srcset` of the `<source>` tag and the light mode version appears in the `src` of the `<img>` tag.

<!-- prettier-ignore-start -->
```html
<picture>
  <source media="(prefers-color-scheme: dark)" srcset="https://readme-typing-svg.demolab.com/?lines=You+are+using+dark+mode&color=FFFFFF" />
  <img src="https://readme-typing-svg.demolab.com/?lines=You+are+using+light+mode&color=000000" />
</picture>
```
<!-- prettier-ignore-end -->

## How do I create a Readme for my profile?

A profile readme appears on your profile page when you create a repository with the same name as your username and add a `README.md` file to it. For example, the repository for the user [`DenverCoder1`](https://github.com/DenverCoder1) is located at [`DenverCoder1/DenverCoder1`](https://github.com/DenverCoder1/DenverCoder1).
