# httpstati

A command-line tool for having a quick look at the different HTTP status codes
defined in the W3 HTTP protocol [RFC 2616, section 10][rfc2616].

Instead of Googling _http status codes_, you can `Ctrl+Alt+T` (YMMV) and

    $ httpstati
    
[![asciicast](https://asciinema.org/a/9p4hqsln4p0a3n30vezuy37vq.png)](https://asciinema.org/a/9p4hqsln4p0a3n30vezuy37vq)

## Installation

### Requirements

-   CLI-ready PHP 5.4+
-   A commandline able to run PHP scripts

_httpstati_ is based on Symfony Console, so if you can run Composer for instance,
you can run _httpstati_.

### Download and test

Download the `httpstati.phar` file and make sure `which php` returns a CLI usable PHP
binary path. Also make sure you've set the permissions to execute it:

    $ chmod +x httpstati.phar

Running `./httpstati.phar` should return general info about the app and a humongous
list of (~2) commands which you can use.

If you want to make the application globally available, you can

    $ sudo ln -s /path/to/downloaded/httpstati.phar /usr/bin/httpstati
    $ # or perhaps
    $ sudo mv ./httpstati.phar /usr/bin/httpstati

## Usage

### List HTTP status codes

You can list all generally used/available status codes using

    $ httpstati codes
    
The command will dump a table with codes and their names. This is also the default
command so using

    $ httpstati
    
yields the same results if no arguments are needed.

### List HTTP status codes for a certain type category

A type category meaning 1xx, 2xx, 3xx and so on.

    $ httpstati codes --category=2
    $ # or
    $ httpstati codes -c2
    
This will output the same table as the previous command, with only displays the codes
which are in the set category.

### Show information for a status code category

You can view a description for a category (e.g. 1xx, 2xx, etc.) using

    $ httpstati codes 2
    $ # or
    $ httpstati codes 2xx
    
Will output a simple manpageish text for the category.

### Show information for a specific status code

You can view a description for a single status code using

    $ httpstati codes 404
    $ # or
    $ httpstati codes 500
    $ # and so on ...
    
Will display a manpageish view for the status code.

### Read about the application

Use

    $ httpstati about
    
To read some general information about this application.

## Todo

-   Tests. Not a big application but the basic output logic should be tested.
-   Validate the data is up-to-date. The RFC is old and mentions other later RFCs as
    valid RFCs.
-   The `codes` as a command is a bit redundant currently. Perhaps find a way to use
    the status code numbering as a command directly.
-   Simpler installation procedure, auto-updates using `httpstati update` or
    something.
-   Expand the content. Perhaps an `example` command on situation where to return
    and use certain HTTP status codes. Maybe a `references` command with links to
    relevant documents, articles and discussions on certain codes and best practices.

## Development

Pull requests welcome. Make a fork and create a topic branch.

## License and other information

-   Licensed with GPLv3. See `LICENSE.md`.
-   Most content copied and/or slightly modified from [RFC 2616, section 10][rfc2616]
    regarding HTTP status codes.
-   Thanks to [Matt Ketmo][mattketmo] for his [Phar packaged CLI apps guide][guide]. 

[rfc2616]: http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10
[mattketmo]: https://github.com/MattKetmo
[guide]: https://moquet.net/blog/distributing-php-cli/
