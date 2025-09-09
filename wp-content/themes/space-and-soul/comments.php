<?php
/**
 * The template for displaying comments
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// If the current post is protected by a password and the visitor doesn't have the password, return early
if ( post_password_required() ) {
    return;
}

/**
 * Custom comment callback
 */
function space_and_soul_comment_callback( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php
                    if ( 0 != $args['avatar_size'] ) {
                        echo get_avatar( $comment, $args['avatar_size'] );
                    }
                    ?>
                    <div class="comment-metadata">
                        <cite class="fn"><?php comment_author_link(); ?></cite>
                        <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                            <time datetime="<?php comment_time( 'c' ); ?>">
                                <?php
                                printf( esc_html__( '%1$s at %2$s', 'space-and-soul' ), get_comment_date(), get_comment_time() );
                                ?>
                            </time>
                        </a>
                        <?php edit_comment_link( esc_html__( 'Edit', 'space-and-soul' ), '<span class="edit-link">', '</span>' ); ?>
                    </div>
                </div>

                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'space-and-soul' ); ?></p>
                <?php endif; ?>
            </footer>

            <div class="comment-content">
                <?php comment_text(); ?>
            </div>

            <?php
            comment_reply_link( array_merge( $args, array(
                'add_below' => 'div-comment',
                'depth'     => $depth,
                'max_depth' => $args['max_depth'],
            ) ) );
            ?>
        </article>
    <?php
}
?>

<div id="comments" class="comments-area">
    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ( '1' === $comments_number ) {
                printf( esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'space-and-soul' ), '<span>' . get_the_title() . '</span>' );
            } else {
                printf(
                    esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comments_number, 'comments title', 'space-and-soul' ) ),
                    number_format_i18n( $comments_number ),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'      => 'ol',
                'short_ping' => true,
                'callback'   => 'space_and_soul_comment_callback',
            ) );
            ?>
        </ol>

        <?php
        the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note
        if ( ! comments_open() ) :
            ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'space-and-soul' ); ?></p>
            <?php
        endif;
    endif;

    // Comment form
    $commenter = wp_get_current_commenter();
    $comment_form_args = array(
        'title_reply'          => esc_html__( 'Leave a Comment', 'space-and-soul' ),
        'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'space-and-soul' ),
        'cancel_reply_link'    => esc_html__( 'Cancel Reply', 'space-and-soul' ),
        'label_submit'         => esc_html__( 'Post Comment', 'space-and-soul' ),
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'space-and-soul' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>',
        'fields'               => array(
            'author' => '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'space-and-soul' ) . '</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required /></p>',
            'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'space-and-soul' ) . '</label><input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" required /></p>',
            'url'    => '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'space-and-soul' ) . '</label><input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
        ),
    );

    comment_form( $comment_form_args );
    ?>
</div>

