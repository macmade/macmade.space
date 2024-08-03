<?php

/*******************************************************************************
 * The MIT License (MIT)
 * 
 * Copyright (c) 2024 Jean-David Gadina - www.xs-labs.com
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 ******************************************************************************/

function GetFileSize( $file )
{
    $size = filesize( $file );
    
    if( $size === false )
    {
        return "";
    }
    else if( $size < 1024 )
    {
        return $size . " bytes";
    }
    else if( $size < 1024 * 1024 )
    {
        return round( $size / 1024, 2 ) . " KB";
    }
    else if( $size < 1024 * 1024 * 1024 )
    {
        return round( ( $size / 1024 ) / 1024, 2 ) . " MB";
    }
    else
    {
        return round( ( ( $size / 1024 ) / 1024 ) / 1024, 2 ) . " GB";
    }
}

function DownloadButtons( $image )
{
    $sizes = array
    (
        array( "3.4-3840x2880",        "3:4",        "3840x2880" ),
        array( "4K-16.9-3840x2160",    "4K 16:9",    "3840x2160" ),
        array( "5K-16.9-5120x2880",    "5K 16:9",    "5120x2880" ),
        array( "16.10-2560x1664",      "16:10",      "2560x1664" ),
        array( "16.10-2880x1864",      "16:10",      "2880x1864" ),
        array( "16.10-3024x1964",      "16:10",      "3024x1964" ),
        array( "16.10-3456x2234",      "16:10",      "3456x2234" ),
        array( "Ultra-Wide-3440x1440", "Ultra Wide", "3440x1440" ),
        array( "Ultra-Wide-6880x2880", "Ultra Wide", "6880x2880" ),
    );
    
    foreach( $sizes as $size )
    {
        $root     = str_replace( $_SERVER[ 'SCRIPT_NAME' ], '', $_SERVER[ 'SCRIPT_FILENAME' ] );
        $filename = $image . "-" . $size[ 0 ] . ".png";
        $file     = $root . "/downloads/" . $size[ 0 ] . "/" . $filename;
        
        echo '<li>' . chr( 10 );
        echo '    <a href="/download.php?image=' . $image . '&size=' . $size[ 0 ] . '" role="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">' . chr( 10 );
        echo '        <i class="bi bi-card-image"></i>' . chr( 10 );
        echo '        <small>' . chr( 10 );
        echo '            <span class="text-warning-emphasis">' . $size[ 1 ] . '</span>' . chr( 10 );
        echo '            <span class="text-secondary">&nbsp;' . $size[ 2 ] . '</span>' . chr( 10 );
        echo '            <span class="text-info-emphasis">&nbsp;' . GetFileSize( $file ) . '</span>' . chr( 10 );
        echo '        </small>' . chr( 10 );
        echo '    </a>' . chr( 10 );
        echo '</li>' . chr( 10 );
    }
}

function Gallery()
{
    $json = file_get_contents( "./gallery.json" );
    
    if( $json === false )
    {
        echo '<div>Error: Cannot read gallery.json</div>' . chr( 10 );
        
        return;
    }
    
    $gallery = json_decode( $json );
    
    if( $gallery === NULL )
    {
        echo '<div>Error: Cannot parse gallery.json</div>' . chr( 10 );
        
        return;
    }
    
    foreach( $gallery as $image )
    {
        echo '<div class="col">' . chr( 10 );
        echo '    <div class="card shadow-sm">' . chr( 10 );
        echo '        <img class="rounded" src="/downloads/Preview/' . $image->file . '-Preview.jpg" alt="' . $image->title . '" aria-label="' . $image->title . '">' . chr( 10 );
        echo '        <div class="card-body">' . chr( 10 );
        echo '            <p class="card-text">' . $image->title . '</p>' . chr( 10 );
        echo '            <div class="d-flex justify-content-between align-items-center">' . chr( 10 );
        echo '                <button class="btn btn-sm btn-secondary dropdown-toggle d-flex align-items-center" id="download-' . $image->file . '" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Download">' . chr( 10 );
        echo '                    <i class="bi bi-box-arrow-down"></i>' . chr( 10 );
        echo '                    Download' . chr( 10 );
        echo '                </button>' . chr( 10 );
        echo '                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="download-' . $image->file . '">' . chr( 10 );
        
        DownloadButtons( $image->file );
        
        echo '                </ul>' . chr( 10 );
        echo '                <small class="text-body-secondary text-sm-end">' . $image->date . '</small>' . chr( 10 );
        echo '            </div>' . chr( 10 );
        echo '        </div>' . chr( 10 );
        echo '    </div>' . chr( 10 );
        echo '</div>' . chr( 10 );
    }
}

Gallery();
