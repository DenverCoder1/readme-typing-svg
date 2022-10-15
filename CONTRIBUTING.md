## Contributing

Contributions are welcome! Feel free to open an issue or submit a pull request if you have a way to improve this project.

Make sure your request is meaningful and you have tested the app locally before submitting a pull request.

### Installing Requirements

#### Requirements

* [PHP 7.4+](https://www.apachefriends.org/index.html)
* [Composer](https://getcomposer.org)

#### Linux

```bash
sudo apt-get install php
sudo apt-get install php-curl
sudo apt-get install composer
```

#### Windows

Install PHP from [XAMPP](https://www.apachefriends.org/index.html) or [php.net](https://windows.php.net/download)

[▶ How to install and run PHP using XAMPP (Windows)](https://www.youtube.com/watch?v=K-qXW9ymeYQ)

[📥 Download Composer](https://getcomposer.org/download/)

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

Run the following command to run prettier on the code, to format the code:
```
composer run format
```

Run the following commad to check if your code is formatted properly:
```
composer run format:check
```
NOTE: You need to have [`prettier`](https://prettier.io/) and the [prettier-php plugin](https://github.com/prettier/plugin-php) installed globally in order to run this command.

Run the following command to run the PHPUnit test script which will verify that the tested functionality is still working.

```bash
composer test
```
