---
name: Question
about: I have a question about this project
title: Question
labels: question
assignees: ''

---

name: ❓ Question
description: Ask a question about the project
title: "❓ Question: "
labels: ["question"]
body:
  - type: markdown
    attributes:
      value: Thanks for taking the time to ask a question! 🙏
  - type: textarea
    id: description
    attributes:
      label: Description
      description: Description of the question. What would you like to know?
    validations:
      required: true
