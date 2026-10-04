# Security Policy

## Supported Versions

Security updates are generally provided for the latest version of Readme Typing SVG.

| Version        | Supported |
| -------------- | --------- |
| Latest         | ✅         |
| Older versions | ❌         |

## Reporting a Vulnerability

If you believe you have discovered a security vulnerability in Readme Typing SVG, please report it responsibly.

**Please do not publicly disclose the vulnerability through GitHub Issues, pull requests, discussions, or other public channels before it has been investigated and addressed.**

When reporting a vulnerability, please include:

* A clear description of the vulnerability
* The affected component, endpoint, or functionality
* Steps to reproduce the issue
* The potential security impact
* Any relevant proof-of-concept code or request
* The version or commit where the issue was discovered
* Any suggested mitigation, if available

### Contact

Please contact the project maintainers privately through the repository's available security reporting mechanism.

If GitHub Security Advisories are enabled for this repository, please use the **Report a vulnerability** option under the repository's **Security** tab.

For vulnerabilities that cannot be reported through GitHub Security Advisories, please contact the maintainers directly through a private channel associated with the project.

## What to Expect

After receiving a vulnerability report, maintainers will:

1. Acknowledge the report when possible.
2. Review and reproduce the reported issue.
3. Determine its security impact and severity.
4. Work on a fix or mitigation.
5. Release the appropriate update when necessary.
6. Credit the reporter if they wish to be publicly acknowledged.

Please avoid publicly discussing the vulnerability until a fix or mitigation has been released.

## Security Considerations

Readme Typing SVG dynamically generates SVG content based on user-provided parameters. Security reports involving:

* SVG/XML injection
* Cross-site scripting (XSS)
* Server-side code execution
* Path traversal
* Server-side request forgery (SSRF)
* Unsafe file handling
* Dependency vulnerabilities
* Denial-of-service conditions
* Authentication or authorization issues
* Information disclosure

are especially welcome.

Reports concerning the hosted demo/service should include the exact endpoint and parameters involved, while avoiding the submission of private or sensitive information.

## Dependency Security

The project uses Composer for PHP dependency management. Dependencies should be kept reasonably up to date and security advisories should be reviewed when updating packages.

Contributors should avoid introducing dependencies that are unnecessary or unmaintained.

## Responsible Disclosure

We appreciate responsible security research. Please give maintainers a reasonable opportunity to investigate and address a vulnerability before publicly disclosing technical details.

Thank you for helping keep Readme Typing SVG and its users secure.
