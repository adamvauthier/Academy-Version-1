<?php
/*
* Template Name: Homepage template
* @package Academies_V1
*/
function date3339($timestamp=0) {

    if (!$timestamp) {
        $timestamp = time();
    }
    $date = date('Y-m-d\TH:i:s', $timestamp);

    $matches = array();
    if (preg_match('/^([\-+])(\d{2})(\d{2})$/', date('O', $timestamp), $matches)) {
        $date .= $matches[1].$matches[2].':'.$matches[3];
    } else {
        $date .= 'Z';
    }
    return $date;
}

get_header();
$_SESSION['home'] = '';
if(is_front_page()){
	$_SESSION['home'] = 'true';
}
else{
  $_SESSION['home'] = 'false';
  }
?>

	<div id="primary" class="content-area homeprimary">
		<main id="main" class="site-main" role="main">
		<?php $page = get_query_var('page_id'); while ( have_posts() ) : the_post(); ?>

      <div class="clear"></div>
      
<section class="buttons">
        <?php if(get_field('detail_buttons')): ?>
            <?php while(has_sub_field('detail_buttons')): ?>
               <a href="<?php the_sub_field('button_link'); ?>" <?php if (get_sub_field('open_new')) { ?>  target="_blank" <?php } ?>> <?php the_sub_field('button_text'); ?></a>
            <?php endwhile; ?>
        <?php endif; ?>
      </section> 



<section class="news">
         <h3><a href="/category/homepage-news/">News &rsaquo;</a></h3>
					<?php $query = new WP_Query( array( 'category_name' => 'homepage-news', 'order' => 'DESC','posts_per_page' => 3 ) );
					if ( $query->have_posts() ) : ?>
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>	
						<article class="entry">
             <a href="<?php the_permalink(); ?>" class="img-header"><?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail'); } ?></a>
             <span class="date"><?php the_time('F j, Y' ) ?></span> 
						 <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
            <span class="text"> <?php $count=strlen (get_the_excerpt()); echo
            substr(get_the_excerpt(), 0,100); if ($count >100) {echo '...';}
              ?> </span>
						</article>
					<?php endwhile; wp_reset_postdata(); ?>
				<?php endif; ?>
      </section>
       
    <?php endwhile;  ?>

 
  <?php $url=site_url();
				if(get_field('middle_column_events') == 'events'): ?>
      <section class="events" id="events">
        	<h3><a href="/events/">Events &rsaquo;</a></h3>
          <?php $i = 0; query_posts( array( 'post_type' => 'event', 'showposts' => -1) );
					if ( have_posts() ) : while ( have_posts() ) : the_post(); 
					?>	
  					<?php
						
						$startdate= get_field ('event_start_date'); 
								$startdate = strtotime($startdate);
								$startdate = strtotime ( '+1 day' , $startdate );
								$enddate= get_field ('event_end_date');
								$enddate = strtotime($enddate);									
										if(get_field ('event_end_date')) { 
                      
                       //echo strtotime("now");
                      if($enddate >= strtotime("now")) {
								get_template_part( 'template-parts/content-single-event', get_post_format() );
								      }}
										else{if($startdate >= strtotime("now")) {
                      get_template_part( 'template-parts/content-single-event', get_post_format() );}}
                            ?>
                    
					<?php endwhile; ?>
  						<?php endif; ?> 
               <?php else: ?>
  <section class="events">
        	<h3><a href="/calendar/">Calendar &rsaquo;</a></h3>
          	<?php 
  											$events = array();
                        $timestamp = urlencode(date3339());
  											$calendarUrl = 'https://www.googleapis.com/calendar/v3/calendars/'.get_field('calendar_id').'/events?singleEvents=true&maxResults=4&orderBy=startTime&timeMin='.$timestamp.'&key='.get_field('api_key');
                        $json = file_get_contents($calendarUrl);
                        $obj = json_decode($json);
                        foreach($obj->items as $event){
			  if($event->start->date){
                          $startDate = date('M j', strtotime($event->start->date));
   			  $timeCode = substr($event->start->date, 0, -6);
			  }
			  else {
			   $startDate = date('M j', strtotime($event->start->dateTime));
			   $timeCode = substr($event->start->dateTime, 0, -6);
	    		  }	
			  if($event->end->date){
                          $timeCode2 = substr($event->end->date, 0, -6);
			  }
			  else {
			   $timeCode2 = substr($event->end->dateTime, 0, -6);
	    		  }	
			  $startTime = date('g:i a', strtotime($timeCode));
                          $endTime = date('g:i a', strtotime($timeCode2));
		          if($startTime != $endTime) {
                          $events[$startDate][] = '<div class="gce-list-event gce-tooltip-event"><a href="'.$event->htmlLink.'" target="_blank">'.$event->summary.'</a></div>Starts: '.$startTime.' Ends: '.$endTime;
}
else {
$events[$startDate][] = '<div class="gce-list-event gce-tooltip-event"><a href="'.$event->htmlLink.'" target="_blank">'.$event->summary.'</a></div>';
}

                        }
  										  echo '<aside class="widget_gce_widget"><div class="gce-list-grouped">';
  											foreach($events as $key => $event){
                         echo '<div class="gce-event-day"><div class="gce-list-title">'.$key.'</div><div class="gce-feed">';
                           foreach($event as $listing){
			     echo '<div class="gce-feed">&nbsp;';
                             echo $listing; 
			     echo '</div>';
                           }
                          echo '</div><div>';
                        }
   echo '</div></aside></div>';
                        ?>
<div class="clear"></div>      
</section> 
  						<?php endif; ?>  
      
      
  </section>
    
<?php get_footer(); ?>