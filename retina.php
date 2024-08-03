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

if( !isset( $_SERVER[ 'REQUEST_URI' ] ) )
{
    exit( 0 );
}

$REQUEST = $_SERVER[ 'REQUEST_URI' ];
$ROOT    = str_replace( $_SERVER[ 'SCRIPT_NAME' ], '', $_SERVER[ 'SCRIPT_FILENAME' ] );
$PATH    = str_replace( '/', DIRECTORY_SEPARATOR, $REQUEST );
$IMG     = $ROOT . $PATH;
$POS     = strrpos( $IMG, '.' );

if( $POS === false )
{
    exit( 0 );
}

$EXT    = substr( $IMG, $POS );
$RETINA = substr( $IMG, 0, $POS ) . '@2x' . $EXT;

if( $EXT == '.png' )
{
    header( 'Content-type: image/png' );
}
else if( $EXT == '.jpg' || $EXT == '.jpeg' )
{
    header( 'Content-type: image/jpeg' );
}
else if( $EXT == '.gif' )
{
    header( 'Content-type: image/gif' );
}

if( file_exists( $RETINA ) )
{
    readfile( $RETINA );
}
else if( file_exists( $IMG ) )
{
    readfile( $IMG );
}

exit( 0 );
