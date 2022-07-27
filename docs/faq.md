# How do I include Readme Typing SVG in my Readme?

Markdown files on GitHub support embedded images using Markdown or HTML.

Image version:

```html
[![Typing SVG](https://readme-typing-svg.herokuapp.com/?lines=First+line+of+text;Second+line+of+text)](https://git.io/typing-svg)
```

HTML version:

```html
  <img src="https://readme-typing-svg.herokuapp.com/?lines=Type+messages+everywhere!;Add+a+bio+to+your+profile!;Add+a+description+to+your+repo!;Make+your+readme+stand+out!&font=Fira%20Code&center=true&width=380&height=50">
```

# FAQs

## 1. Help — how do I center the Image/Typing SVG?

We can do so by *using the HTML version*, and then wrapping it by the HTML attribute of `align="center"`.

You can do so by:

```html
<p align="center">
    <img src="https://readme-typing-svg.herokuapp.com/?lines=Type+messages+everywhere!;Add+a+bio+to+your+profile!;Add+a+description+to+your+repo!;Make+your+readme+stand+out!&font=Fira%20Code&center=true&width=380&height=50">
</p>
```
>Note: Why do we have to use the HTML version? It is because we can only use the `align="center"` on a HTML attribute.