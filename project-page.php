<?php
/*
Template Name: Project Page
*/

get_header();

// Custom query to retrieve Projects (CPT)
$args = array(
    'post_type'      => 'project', // Replace 'project' with your actual CPT slug
    'posts_per_page' => -1,        // Set to -1 to retrieve all posts
);

$projects_query = new WP_Query($args);

if ($projects_query->have_posts()) :
    ?>
    <div class="project-grid">
        <?php
        while ($projects_query->have_posts()) : $projects_query->the_post();
            // You can customize the grid item markup here
            ?>
            <a href="<?php the_permalink(); ?>" class="project-item"> <!-- Added the link here -->
                <h2 class="project-title"><?php the_title(); ?></h2>
                
                <?php
                // Display the project image using ACF
                $project_image = get_field('project_image');
                if ($project_image) {
                    echo '<img src="' . esc_url($project_image['url']) . '" alt="' . esc_attr(get_the_title()) . '" class="project-image">';
                }
                ?>

                <div class="project-content">
                    <?php
                    // Display the project short content
                    $project_short_content = get_post_meta(get_the_ID(), 'project_short_content', true);
                    if (!empty($project_short_content)) {
                        echo '<p class="project-short-content">' . esc_html($project_short_content) . '</p>';
                    }
                    ?>
                </div>
            </a> 
            <?php
        endwhile;
        ?>
    </div>
    <?php
    wp_reset_postdata();
else :
    ?>
    <p>No projects found.</p>
    <?php
endif;

get_template_part('template-parts/modules');
get_footer();
?>

<style>
.project-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    background-color: #000;
    padding: 32px;
    
}
a, a:active, a:hover, a:link, a:visited {
    text-decoration: none;
    color: #ffffff;
}
.project-title {
    min-height: 40px;
    font-size: 26px;
    line-height: 26px;
}

.project-image {
    width: 100%; 
    height: auto; 
}

.project-content {
    margin-top: 10px; 
}
.project-item {
    width: calc(50% - 20px);
    margin-bottom: 20px;
    color: white;
    padding: 20px;
    border: 0.2px solid #0e1f33;
    margin: 5px;
}
.project-item:hover {
   background-color: #0e1f33;
}


@media (max-width: 768px) {
    .project-item {
        width: calc(50% - 20px);
    }
}

@media (max-width: 480px) {
    .project-item {
        width: 100%;
    }
}


</style>