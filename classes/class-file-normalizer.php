<?php

namespace Media_Filename_Normalizer;

use WP_Query;

defined( 'ABSPATH' ) || exit;

class File_Normalizer {

  function __construct() {

    add_filter( 'wp_handle_upload_prefilter', [ $this, 'upload_filter' ] );

    add_action( 'admin_head', [ $this, 'process_existing_files' ] );

  }

  public function process_existing_files() {

    $q = new WP_Query( [
      'post_type'      => 'attachment',
      //'post_mime_type' => 'image',
      'post_status'    => 'inherit',
      'posts_per_page' => - 1,
    ] );

    if ( $q->have_posts() ) {
      echo '<ul>';
      while ( $q->have_posts() ) {
        $q->the_post();
        echo '<li>' . get_the_title() . '</li>';
      }
      echo '</ul>';
    }

    wp_reset_postdata();

  }

  public function upload_filter( $file ) {

    if ( get_option( 'mfnn-normalize-on-upload', 1 ) ) {
      $file['name'] = $this->clean_filename( $file['name'] );
    }

    return $file;

  }

  private function clean_filename( $filename ) {

    // Get file details.
    $file_pathinfo = pathinfo( $filename );

    // Replace whitespaces with dashes.
    $cleaned_filename = str_replace( ' ', '-', $file_pathinfo['filename'] );

    // Specific replacements not handled at all or not handled well by remove_accents().
    $specific_replacements = [
      'А'   => 'a',
      'Ά'   => 'a',
      'Á'   => 'a',
      'Α'   => 'a',
      'Ä'   => 'a',
      'Å'   => 'a',
      'Ã'   => 'a',
      'Â'   => 'a',
      'À'   => 'a',
      'α'   => 'a',
      'Ą'   => 'a',
      'а'   => 'a',
      'ά'   => 'a',
      'Æ'   => 'ae',
      'å'   => 'a',
      'ä'   => 'a',
      'б'   => 'b',
      'Б'   => 'b',
      'Ć'   => 'c',
      'Ç'   => 'c',
      'ц'   => 'c',
      'Ц'   => 'c',
      'Č'   => 'c',
      'Ч'   => 'ch',
      'χ'   => 'ch',
      'ч'   => 'ch',
      'Χ'   => 'ch',
      'д'   => 'd',
      'Ď'   => 'd',
      'Д'   => 'd',
      'δ'   => 'd',
      'Δ'   => 'd',
      'Ð'   => 'd',
      'ε'   => 'e',
      'έ'   => 'e',
      'Έ'   => 'e',
      'Э'   => 'e',
      'Ę'   => 'e',
      'Ε'   => 'e',
      'э'   => 'e',
      'Ê'   => 'e',
      'Ě'   => 'e',
      'É'   => 'e',
      'Е'   => 'e',
      'е'   => 'e',
      'È'   => 'e',
      'Ë'   => 'e',
      'Φ'   => 'f',
      'Ф'   => 'f',
      'φ'   => 'f',
      'ф'   => 'f',
      'Γ'   => 'g',
      'γ'   => 'g',
      'ґ'   => 'g',
      'Г'   => 'g',
      'Ґ'   => 'g',
      'г'   => 'g',
      'Х'   => 'h',
      'х'   => 'h',
      'Ή'   => 'i',
      'Ί'   => 'i',
      'І'   => 'i',
      'і'   => 'i',
      'ΐ'   => 'i',
      'Η'   => 'i',
      'Ι'   => 'i',
      'η'   => 'i',
      'ϊ'   => 'i',
      'ι'   => 'i',
      'Ï'   => 'i',
      'Ì'   => 'i',
      'ή'   => 'i',
      'Í'   => 'i',
      'Î'   => 'i',
      'ί'   => 'i',
      'Ϊ'   => 'i',
      'и'   => 'i',
      'И'   => 'i',
      'й'   => 'j',
      'Й'   => 'j',
      'Я'   => 'ja',
      'я'   => 'ja',
      'ю'   => 'ju',
      'Ю'   => 'ju',
      'Κ'   => 'k',
      'κ'   => 'k',
      'к'   => 'k',
      'К'   => 'k',
      'л'   => 'l',
      'Λ'   => 'l',
      'λ'   => 'l',
      'Ł'   => 'l',
      'Л'   => 'l',
      'Μ'   => 'm',
      'м'   => 'm',
      'М'   => 'm',
      'μ'   => 'm',
      'Ñ'   => 'n',
      'ν'   => 'n',
      'Ν'   => 'n',
      'н'   => 'n',
      'Ň'   => 'n',
      'Ń'   => 'n',
      'Н'   => 'n',
      'ώ'   => 'o',
      'Ò'   => 'o',
      'ό'   => 'o',
      'Ő'   => 'o',
      'Ώ'   => 'o',
      'Õ'   => 'o',
      'Ο'   => 'o',
      'Ø'   => 'o',
      'ο'   => 'o',
      'Ό'   => 'o',
      'Ω'   => 'o',
      'Ó'   => 'o',
      'Ö'   => 'o',
      'ö'   => 'o',
      'О'   => 'o',
      'о'   => 'o',
      'ω'   => 'o',
      'Ô'   => 'o',
      'п'   => 'p',
      'þ'   => 'p',
      'π'   => 'p',
      'Π'   => 'p',
      'П'   => 'p',
      'Þ'   => 'p',
      'Ψ'   => 'ps',
      'ψ'   => 'ps',
      'Р'   => 'r',
      'Ř'   => 'r',
      'Ρ'   => 'r',
      'р'   => 'r',
      'ρ'   => 'r',
      'С'   => 's',
      'σ'   => 's',
      'Ś'   => 's',
      'ς'   => 's',
      'Σ'   => 's',
      'Š'   => 's',
      'с'   => 's',
      'Ш'   => 'sh',
      'ш'   => 'sh',
      'щ'   => 'shch',
      'Щ'   => 'shch',
      'ß'   => 'ss',
      'Τ'   => 't',
      'τ'   => 't',
      'Ť'   => 't',
      'т'   => 't',
      'Т'   => 't',
      'θ'   => 'th',
      'Θ'   => 'th',
      'Ў'   => 'u',
      'ў'   => 'u',
      'Ű'   => 'u',
      'Ú'   => 'u',
      'У'   => 'u',
      'Ù'   => 'u',
      'Û'   => 'u',
      'Ů'   => 'u',
      'у'   => 'u',
      'ü'   => 'u',
      'Ü'   => 'u',
      'в'   => 'v',
      'В'   => 'v',
      'Β'   => 'v',
      'β'   => 'v',
      'Ξ'   => 'x',
      '×'   => 'x',
      'ξ'   => 'x',
      'Ϋ'   => 'y',
      'Ÿ'   => 'y',
      'Ý'   => 'y',
      'Υ'   => 'y',
      'υ'   => 'y',
      'Ύ'   => 'y',
      'ύ'   => 'y',
      'ΰ'   => 'y',
      'ϋ'   => 'y',
      'ы'   => 'y',
      'Ы'   => 'y',
      'є'   => 'ye',
      'Є'   => 'ye',
      'ї'   => 'yi',
      'Ї'   => 'yi',
      'ё'   => 'yo',
      'Ё'   => 'yo',
      'з'   => 'z',
      'Ź'   => 'z',
      'З'   => 'z',
      'Ž'   => 'z',
      'ζ'   => 'z',
      'Ζ'   => 'z',
      'Ż'   => 'z',
      'Ж'   => 'zh',
      'ж'   => 'zh',
      '_'   => '-',
      '%20' => '-',
    ];

    // Allows developers to add or modify replacements
    $specific_replacements = apply_filters( 'mfnn-replacements', $specific_replacements );

    // Replace specific characters.
    $cleaned_filename = str_replace(
      array_keys( $specific_replacements ),
      array_values( $specific_replacements ),
      $cleaned_filename
    );

    // Convert characters to ASCII equivalents.
    $cleaned_filename = remove_accents( $cleaned_filename );

    // Remove characters that are not a-z, 0-9, or - (dash).
    $cleaned_filename = preg_replace( '/[^a-zA-Z0-9-]/', '', $cleaned_filename );

    // Remove multiple dashes in a row.
    $cleaned_filename = preg_replace( '/-+/', '-', $cleaned_filename );

    // Trim potential leftover dashes at each end of filename.
    $cleaned_filename = trim( $cleaned_filename, '-' );

    // Convert filename to lowercase.
    $cleaned_filename = strtolower( $cleaned_filename );

    return $cleaned_filename . '.' . $file_pathinfo['extension'];

  }

}

new File_Normalizer();
