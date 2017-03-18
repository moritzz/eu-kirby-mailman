# eu-kirby-mailman
A seamless Kirby &amp; GNU Mailman integration

*Version:* 0.1

This is a Kirby snippet (to be used with the [Kirby CMS](getkirby.com)). It's purpose is to provide a seamless integration with [GNU Mailman](http://www.list.org/).

It sets you up with a simple (un)subscriptions form for Mailman. The form triggers Mailman through standard URLs and parses it's responses to use in your frontend. It can handle one or any number of list (although it is not (yet?) able to do multi-(un)subscription an once).

The lists should be provided through the Kirby backend/site settings, [hence](https://vivatiffany.wordpress.com/2016/10/27/academia-love-me-back/) the `eu-kirby-mailman-blueprint.php` example (goes somwhere into your `/blueprints/site.php`).

The aim was to not use any admin- or user-passwords, but to rely solely one double-opt-in/-out through Mailman's built in email confirmation system.

## Todo
- [ ] fix in some environments returning the error 'The listserver did not respond.' although all values are correct.

## Installation

### 1. Download the php file

### 2. Move it to the Kirby Snippets folder 
Move the file to the **Kirby Snippets** folder located in `Kirby ▶ site ▶ snippets`. If it does not exist, create it.

### 3. Call the snippet
Like so: `<?php snippet('eu-kirby-mailman') ?>`

You'll probably want to that within a sidebar or a footer or something.

## Requirements
This thing requires some fields:

- ```$site->mailmanurl()```→ url to mailman itself (like so: `https://lists.example.org/cgi-bin/mailman/`) <sup>[1]</sup>
- ```$site->mailmanlist()```→ name of your mailman list (like so: `info`) <sup>[1]</sup>

[1] = note that you can also add more than one list, that's done by putting the information on each list into the fields after one antotheer (in the same order in both fields & seperating the values by a semicolon `;`)

## Authors
[error:undefined design](http://error-undefined.de/)

## License

[MIT](https://opensource.org/licenses/MIT)

It is discouraged to use this plugin in any project that promotes racism, sexism, homophobia, animal abuse, violence or any other form of hate speech.
