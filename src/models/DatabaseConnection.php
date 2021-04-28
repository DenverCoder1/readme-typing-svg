<?php

/**
 * Class for accessing the font database
 */
class DatabaseConnection
{
    /**
     * PostgreSQL Database Connection
     * @var resource|false
     */
    private $conn = false;

    /**
     * Constructor for DatabaseConnection class
     * Creates a database connection
     */
    public function __construct()
    {
        // database is missing from env
        if (!isset($_ENV["DATABASE_URL"])) {
            return;
        }
        // connect to database
        $conn_string = preg_replace(
            "/^postgres:\/\/(.+?):(.+?)@(.+?):(\d+?)\/(.+)$/",
            "host=$3 port=$4 dbname=$5 user=$1 password=$2",
            $_ENV["DATABASE_URL"]
        );
        $this->conn = pg_connect($conn_string);
    }

    /**
     * Fetch CSS from PostgreSQL Database
     *
     * @param string $font - Google Font to fetch
     * @return array<string> - date and CSS for displaying the font
     */
    public function fetchFontCSS($font)
    {
        // check connection
        if ($this->conn) {
            // fetch font from database
            $result = pg_query_params($this->conn, 'SELECT fetch_date, css FROM fonts WHERE family = $1', array($font));
            if (!$result) {
                return false;
            }
            $row = pg_fetch_row($result);
            if ($row) {
                return $row;
            }
        }
        return false;
    }

    /**
     * Insert font CSS into database
     *
     * @param string $font - Font Family
     * @param string $css - CSS with Base64 encoding
     * @return bool - True if successful, false if connection failed
     */
    public function insertFontCSS($font, $css)
    {
        if ($this->conn) {
            $entry = array(
                "family" => $font,
                "css" => $css,
                "fetch_date" => date('Y-m-d'),
            );
            $result = pg_insert($this->conn, 'fonts', $entry);
            if (!$result) {
                throw new InvalidArgumentException("Insertion of Google Font to database failed");
            }
            return true;
        }
        return false;
    }
}
