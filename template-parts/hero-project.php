<?php
/**
 * Template for hero for single project page.
 *
 * @package Milos
 * @subpackage Chriss
 */

$title = get_field('hero_title');
if (!$title) :
    $title = get_the_title();
endif;

$text = get_field('hero_text');
$vertical_text = get_field('hero_vertical_text');

$classes = array(
    'module-hero',
    'module-hero-sector',
);

$projects_post_id = get_field('projects_page', 'options');
$projects_post_title = get_the_title($projects_post_id);

// New Fields
$project_image = get_field('project_image');
$project_video = get_field('project_video');
$short_description = get_field('project_short_content');
$content = get_field('project_content');
$project_directors = get_field('project_director'); 

?>
<div <?php the_css_class($classes); ?>>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-offset-2 col-md-8">
                        <div class="wrapper">
                            <h1 class="heading-01"><?php echo esc_html($title); ?></h1>
                            
                            <?php echo $text; ?>

                            <!-- Display New Fields -->
                            <?php if ($content) : ?>
                                <div class="project-content">
                                    <?php echo $content; ?>
                                </div>
                            <?php endif; ?>

                           

							<?php if ($project_video) : ?>
    </div> 
</div> 
<div class="row">
    <div class="col-md-12">
        <div class="video-wrapper-project">
            <video id="project-video" class="video-project" poster="<?php echo esc_url($project_image['url']); ?>">
                <source src="<?php echo esc_url($project_video['url']); ?>" type="<?php echo esc_attr($project_video['mime_type']); ?>">
                Your browser does not support the video tag.
            </video>
            <div class="play-button-project" onclick="togglePlayProject()">
                <svg class="play-icon-project" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<?php if ($project_directors) : ?>
    <div class="row">
		<div class="project-details">
        <div class="col-md-offset-2 col-md-8">
            <p style="display: inline; margin-right: 10px;">Project Directors:</p>
            <span class="project-directors">
                <?php foreach ($project_directors as $director) : ?>
                    <span style="display: inline; margin-right: 10px;">
                        <p style="display: inline;"><?php echo esc_html($director->post_title); ?></p>
                    </span>
                <?php endforeach; ?>
            </span>
        </div></div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
<?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if ($vertical_text) : ?>
                    <a href="javascript:void(0);" class="show-the-road"><?php echo esc_html($vertical_text); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.video-wrapper-project {
    position: relative;
    max-width: 100%;
}

.video-project {
    width: 100%;
    height: auto;
}

.play-button-project {
    position: unset;
    top: 50%;
    left: 50%;
    cursor: pointer;
    z-index: 1;
    display: block;
}

.play-button-project svg {
    fill: #fff;
}

.play-button-project svg {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 20%;
    height: 20%;
}
.project-details{ 
	margin-top: 50px;
    margin-bottom: 50px;
	text-align: center;
}

</style>

<script>
var videoProject = document.getElementById('project-video');
var playButtonProject = document.querySelector('.play-button-project');

function togglePlayProject() {
    if (videoProject.paused || videoProject.ended) {
        videoProject.play();
        playButtonProject.style.display = 'none';
        videoProject.setAttribute('controls', 'true'); // Show controls when playing
    } else {
        videoProject.pause();
        playButtonProject.style.display = 'block';
        videoProject.removeAttribute('controls'); // Hide controls when paused
    }
}



</script>


