# Custom Post Type Date Archives [![Build Status](https://travis-ci.org/keesiemeijer/custom-post-type-date-archives.svg?branch=develop)](http://travis-ci.org/keesiemeijer/custom-post-type-date-archives) #

Version:           2.1.0  
Requires at least: 3.9  
Tested up to:      4.4  

Add date archives to WordPress custom post types

## Welcome to the GitHub repository for this plugin ##
This is the development repository for the Custom Post Type Date Archives plugin.

The `master` branch is where you'll find the most recent, stable release.
The `develop` branch is the current working branch for development. Both branches are required to pass all unit tests. Any pull requests are first merged with the `develop` branch before being merged into the `master` branch.

* [Plugin Description](https://github.com/keesiemeijer/custom-post-type-date-archives/tree/develop#plugin-description)
* [Adding Date Archives in Themes](https://github.com/keesiemeijer/custom-post-type-date-archives/tree/develop#adding-date-archives-in-themes)
  * [future dates](https://github.com/keesiemeijer/custom-post-type-date-archives/tree/develop#future-dates)
  * [Functions](https://github.com/keesiemeijer/custom-post-type-date-archives/tree/develop#functions)
  * [Pagination](https://github.com/keesiemeijer/custom-post-type-date-archives/tree/develop#pagination)
* [Pull Requests](https://github.com/keesiemeijer/custom-post-type-date-archives/tree/develop#pull-requests)
* [Creating a new build](https://github.com/keesiemeijer/custom-post-type-date-archives/tree/develop#creating-a-new-build)
* [Bugs](https://github.com/keesiemeijer/custom-post-type-date-archives/tree/develop#bugs)

## Plugin Description ##
Add date archives to custom post types right in the dashboard. Selection of a post type is now possible in the calendar and archives widget. This plugin can be used among other things as a super simple events calendar. 

Example url for a custom post type `events` date archive.
```
https://example.com/events/2015/06/12
```

By default WordPress only supports date archives for the `post` post type. This plugin provides the rewrite rules needed for custom post types to also have date archives. This plugin works with your existing (date) theme template files. If you need to integrate the custom post types differently you can make use of [functions](https://github.com/keesiemeijer/custom-post-type-date-archives/tree/develop#functions) provided by this plugin.

**Notice** The custom post types must be [registered](https://codex.wordpress.org/Function_Reference/register_post_type) to have archives and be publicly queryable.

## Adding Date Archives in Themes
Besides adding the date archives in the dashboard you can add date archives in your (child) theme's functions.php file with the [add_post_type_support()](http://codex.wordpress.org/Function_Reference/add_post_type_support) function. Add `date-archives` to the `$supports` parameter and this plugin will add the rewrite rules needed.
When registering a custom post type the `has_archive` parameter is required for it to have date archives added. See the example below. 

For example, add date archives to a `events` custom post type. Put this in your (child) theme's functions.php file. 

```php
function post_type_events_init() {

	$args = array(
		'label'       => 'Events',
		'public'      => true,
		'has_archive' => true, // required for date archives
	);

	// Registering the events custom post type.
	register_post_type( 'events', $args );

	// Adding date archives support to the events custom post type.
	add_post_type_support( 'events', array( 'date-archives' ) );
}

add_action( 'init', 'post_type_events_init' );
```

**Note** The functions [register_post_type()](https://codex.wordpress.org/Function_Reference/register_post_type) and [add_post_type_support()](https://codex.wordpress.org/Function_Reference/add_post_type_support) should be called using the `init` action hook, like in the example above.

### future dates ###
To allow future dates for a post type include `publish-future-posts` in the `$supports` parameter.
```php
// Adding date archives and publish future post support for the 'events' custom post type.
add_post_type_support( 'events', array( 'date-archives', 'publish-future-posts' ) );
```
This will set the post status for **newly** published posts with a scheduled **future date** to `publish` instead of `future`. Scheduled (future) posts are no longer hidden in the front end of your site. To update old scheduled posts with the post status `publish` use this [bulk edit trick](http://bobwp.com/bulk-edit-posts-wordpress/) and set the status to `published` for posts with a future date.

### Functions ###

These are the functions you can use in your theme template files.
See the functions.php file for what each function does.

```php
// Is the current query for a custom post type date archive?
cptda_is_cpt_date()
```

```php
// Checks if a specific post type supports date archives.
cptda_is_date_post_type( $post_type = '' )
```

```php
// Get the posts type for the current custom date archive.
cptda_get_date_archive_cpt()
```

```php
// Get the post stati for a post type thas support date archives. 
// Returns an array with post stati. Default array( 'publish' ).
// If the post type supports 'publish-future-posts' an array with 'publish' and 'future' is returned.
// The post stati can be filtered with the 'cptda_post_stati' filter.

cptda_get_cpt_date_archive_stati( $post_type = '' )
```

```php
// Display archive links based on post type, type and format.
// Similar to wp_get_archives. Use 'post_type' in the $args parameter to set the post type
cptda_get_archives( $args = '' )
```

```php
// Display a calendar for a custom post type with days that have posts as links.
// Similar to the WordPress function get_calendar(). Altered to include a custom post type parameter.
cptda_get_calendar( $post_type = '', $initial = true, $echo = true )
```

```php
// Retrieve the permalink for custom post type year archives.
cptda_get_year_link( $year, $post_type = '' )
```

```php
// Retrieve the permalink for custom post type month archives with year.
cptda_get_month_link( $year, $month, $post_type = '' )
```

```php
// Retrieve the permalink for custom post type day archives with year and month.
cptda_get_day_link( $year, $month, $day, $post_type = '' )
```
### Pagination ###
Pagination of cpt date archives works the same as normal date archives. For those needing to paginate by year, month or day there is a seperate plugin that does just that.
https://github.com/keesiemeijer/custom-post-type-date-archives-pagination

## Pull Requests ##
When starting work on a new feature, branch off from the `develop` branch.
```bash
# clone the repository
git clone https://github.com/keesiemeijer/custom-post-type-date-archives.git

# cd into the custom-post-type-date-archives directory
cd custom-post-type-date-archives

# switch to the develop branch
git checkout develop

# create new branch newfeature and switch to it
git checkout -b newfeature develop
```

## Creating a new build ##
To compile the plugin without all the development files use the following commands:
```bash
# Go to the master branch
git checkout master

# Install Grunt tasks
npm install

# Build the production plugin
grunt build
```
The plugin will be compiled in the `build` directory.

## Bugs ##
If you find an issue, let us know [here](https://github.com/keesiemeijer/custom-post-type-date-archives/issues?state=open)!