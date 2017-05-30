# PHP Sub-Domain

A PHP library to create or delete sub domain in your own application.


### How to use

1. First load the main class.
`PHPSubDomain.php`

2. Instantiate the class with your cpanel username, password, skin name, domain, sudomain name that you want to create, port, and location path. Most of the cpanel uses `x2/x3` skin. Default port is `2082`. And location path is `public_html`

Sample code  

`$domain = new PHPSubDomain('CPANEL_USERNAME', 'CPANEL_PASSWORD', 'YOUR_DOMAIN', 'SUB_DOMAIN_NAME', 'x3', 'public_html/MY_LOCATION', 2082)`;

3. To create a sub domain, run `$domain->create()`

4. To delete a sub domain, run `$domain->delete()`