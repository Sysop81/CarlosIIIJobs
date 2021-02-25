<?php

class CarlosIIIJobs_shortcode
{

    public function CarlosIIIJobs_shortcode_init()
    {
        function CarlosIIIJobs_shortcode($atts = [], $content = null)
        {
            //Declaramos $wpdb como global para interactuar con la BBDD mediante alguna de sus funciones
            global $wpdb;
            
            //Preparamos la consulta, para obtener el numero de ofertas configuradas para el shorcode
            $query = "select option_value from wp_options where option_name = 'CarlosIIIJob_options_nOfertas'";
            
            //Ejecutamos la funcion get_var introduciendo como parametro la consulta preparada en elpaso anterior
            //y cargamos la variable $n_ofertas
            $n_ofertas = $wpdb->get_var($query);
            
            //Establecemos la paginacion mediante la variable $n_ofertas. En el caso de que el shortcode no reciba
            //parametros se ejectura el valor establecido en la varible $n_ofertas, para mostrar el nº ofertas del shortcode
            if(!isset($atts['n_ofertas'])) $atts['n_ofertas'] = $n_ofertas;

            $query = new WP_Query( array( 'post_type' => 'job' , 'posts_per_page' => $atts['n_ofertas']) );
            ob_start();
            if ( $query->have_posts() ) : ?>
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <div>
                        <h2><?php the_title(); ?></h2>
                        <?php the_content(); ?>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
                <!-- show pagination here -->
            <?php else : ?>
                <!-- show 404 error here -->
            <?php endif; ?>
<?php
            $content = ob_get_contents ();
            ob_end_clean();
            return $content;
        }
        add_shortcode('CarlosIIIJobs', 'CarlosIIIJobs_shortcode');
    }

}

