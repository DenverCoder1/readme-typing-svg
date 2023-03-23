## Contributing

Contributions are welcome! Feel free to open an issue or submit a pull request if you have a way to improve this project.

Make sure your request is meaningful and you have tested the app locally before submitting a pull request.

### Installing Requirements

#### Requirements

- [PHP 7.4+](https://www.apachefriends.org/index.html "PHP 7.4+")
- [Composer](https://getcomposer.org "Composer")

#### Linux

```bash
sudo apt-get install php
sudo apt-get install php-curl
sudo apt-get install composer
```

#### Windows

Install PHP from [XAMPP](https://www.apachefriends.org/index.html "XAMPP") or [php.net](https://windows.php.net/download "php.net")

[▶ How to install and run PHP using XAMPP (Windows)](https://www.youtube.com/watch?v=K-qXW9ymeYQ "How to install and run PHP using XAMPP (Windows)")

[📥 Download Composer](https://getcomposer.org/download/ "Download Composer")

### Clone the repository

```
git clone https://github.com/DenverCoder1/readme-typing-svg.git
cd readme-typing-svg
```

### Running the app locally

```bash
composer start
```

Open http://localhost:8000/ and add parameters to run the project locally.

### Running the tests

Before you can run tests, PHPUnit must be installed. You can install it using Composer by running the following command.

```bash
composer install
```

### Format and test the code

Run the following command to format the code with Prettier:

```
composer run format
```

Run the following command to check if your code is formatted properly:

```
composer run format:check
```

> **Note** You need to have [`prettier`](https://prettier.io/ "prettier") and the [prettier-php plugin](https://github.com/prettier/plugin-php "prettier-php plugin") installed globally in order to run this command.

Run the following command to run the PHPUnit test script which will verify that the tested functionality is still working.

```bash
composer test
```
