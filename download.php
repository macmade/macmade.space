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

if( !isset( $_GET[ "image" ] ) || !isset( $_GET[ "size" ] ) || !isset( $_GET[ "type" ] ) )
{
    exit( 0 );
}

$IMAGE    = str_replace( "..", "", $_GET[ "image" ] );
$SIZE     = str_replace( "..", "", $_GET[ "size" ] );
$TYPE     = str_replace( "..", "", $_GET[ "type" ] );
$ROOT     = str_replace( $_SERVER[ 'SCRIPT_NAME' ], '', $_SERVER[ 'SCRIPT_FILENAME' ] );
$FILENAME = $IMAGE . "-" . $SIZE . "." . $TYPE;
$FILE     = $ROOT . "/downloads/" . $SIZE . "/" . $FILENAME;

if( !file_exists( $FILE ) )
{
    exit( 0 );
}

header( 'Content-Description: File Transfer' );
header( 'Content-Type: application/octet-stream' );
header( 'Content-Disposition: attachment; filename=" ' . $FILENAME . '"' );
header( 'Content-Transfer-Encoding: binary' );
header( 'Expires: 0' );
header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
header( 'Pragma: public' );
header( 'Content-Length: ' . filesize( $FILE ) );

ob_clean();
flush();
readfile( $FILE );
exit( 0 );
