<?php
/**
 * Tests for dependencies and various plugin functions
 */
class KM_CPTDA_Post_Type extends WP_UnitTestCase {

	/**
	 * Utils object to create posts to test with.
	 *
	 * @var object
	 */
	private $utils;


	/**
	 * Set up.
	 */
	function setUp() {
		parent::setUp();

		$this->utils = new CPTDA_Test_Utils( $this->factory );
		$this->utils->set_permalink_structure( 'blog/%postname%/' );
	}


	/**
	 * Reset post type on teardown.
	 */
	function tearDown() {
		parent::tearDown();
		$this->utils->unregister_post_type();
	}


	/**
	 * Test if custom post type posts are created.
	 */
	function test_published_posts() {
		$posts = $this->utils->create_posts();
		$this->assertEquals( 7, count( $posts ) );
	}


	/**
	 * Test if posts are created with post status publish.
	 */
	function test_published_posts_init() {
		$this->utils->init();
		$posts = $this->utils->create_posts();
		$this->assertEquals( 7, count( $posts ) );
	}


	/**
	 * Test if posts with future dates are created with post status publish.
	 */
	function test_published_posts_future_init() {
		$this->utils->future_init();
		$posts = $this->utils->create_posts();
		$this->assertEquals( 13, count( $posts ) );
	}

	/**
	 * Test slug with front (blog)
	 */
	function test_cpt_slug_with_front() {
		$this->utils->init();
		$slug = cptda_get_post_type_base( 'cpt' );
		$this->assertEquals( 'blog/cpt', $slug );
	}


	/**
	 * Test slug
	 */
	function test_cpt_slug() {
		$this->utils->set_permalink_structure( '/%postname%/' );
		$this->utils->init();
		$slug = cptda_get_post_type_base( 'cpt' );
		$this->assertEquals( 'cpt', $slug );
	}


	/**
	 * Test rewrite slug
	 */
	function test_cpt_rewrite_slug() {
		$this->utils->init( 'cpt', 'publish', array( 'slug' => 'rewrite', 'with_front' => true ) );
		$slug = cptda_get_post_type_base( 'cpt' );
		$this->assertEquals( 'blog/rewrite', $slug );
	}


	/**
	 * Test rewrite slug without front
	 */
	function test_cpt_rewrite_slug_without_front() {
		$this->utils->init( 'cpt', 'publish', array( 'slug' => 'rewrite', 'with_front' => false ) );
		$plugin = cptda_date_archives();
		$slug = cptda_get_post_type_base( 'cpt' );
		$this->assertEquals( 'rewrite', $slug );
	}


	/**
	 * Test rewrite set to false
	 */
	function test_cpt_rewrite_slug_rewrite_false() {
		global $wp_rewrite;
		$args = array( 'public' => true, 'has_archive' => true, 'rewrite' => false, 'label' => 'Custom Post Type' );
		register_post_type( 'cpt', $args );
		$this->utils->setup( 'cpt' );
		$post_type = get_post_type_object( 'cpt' );
		$slug = cptda_get_post_type_base( 'cpt' );
		$this->assertEquals( '', $slug );
	}

}
