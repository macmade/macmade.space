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
        echo '<li>';
        echo '    <a href="/download.php?image=' . $image . '&size=' . $size[ 0 ] . '" role="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">';
        echo '        <i class="bi bi-card-image"></i>';
        echo '        <small>';
        echo '            ' . $size[ 1 ];
        echo '            <span class="text-body-secondary">&nbsp;' . $size[ 2 ] . '</span>';
        echo '        </small>';
        echo '    </a>';
        echo '</li>';
    }
}

function Gallery()
{
    $json = file_get_contents( "./gallery.json" );
    
    if( $json === false )
    {
        echo '<div>Error: Cannot read gallery.json</div>';
        
        return;
    }
    
    $gallery = json_decode( $json );
    
    if( $gallery === NULL )
    {
        echo '<div>Error: Cannot parse gallery.json</div>';
        
        return;
    }
    
    foreach( $gallery as $image )
    {
        echo '<div class="col">';
        echo '    <div class="card shadow-sm">';
        echo '        <img class="rounded" src="/downloads/Preview/' . $image->file . '-Preview.jpg" role="img" alt="' . $image->title . '" aria-label="' . $image->title . '">';
        echo '        <div class="card-body">';
        echo '            <p class="card-text">' . $image->title . '</p>';
        echo '            <div class="d-flex justify-content-between align-items-center">';        
        echo '                <button class="btn btn-sm btn-primary dropdown-toggle d-flex align-items-center" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Download">';
        echo '                    <i class="bi bi-box-arrow-down"></i>';
        echo '                    Download';
        echo '                </button>';
        echo '                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">';
        
        DownloadButtons( $image->file );
        
        echo '                </ul>';
        echo '                <small class="text-body-secondary text-sm-end">' . $image->date . '</small>';
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
}

Gallery();
