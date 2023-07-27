---
name: Bug report
about: Create a bug report to help us improve
title: "[bug]"
labels: bug
assignees: ''

---

name: 🐛 Bug
description: Submit a bug report to help us improve
title: "🐛 Bug: "
labels: ["bug"]
body:
  - type: markdown
    attributes:
      value: Thanks for taking the time to fill out our bug report form 🙏
  - type: textarea
    id: description
    attributes:
      label: Description
      description: A brief description of the bug. What happened? What did you expect to happen?
    validations:
      required: true
  - type: textarea
    id: steps
    attributes:
      label: Steps to reproduce
      description: How do you trigger this bug? Please walk us through it step by step.
    validations:
      required: true
  - type: textarea
    id: screenshots
    attributes:
      label: Screenshots
      description: Please add screenshots if applicable
    validations:
      required: false
