<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 2018/12/5
 * Time: 6:53 PM
 */

namespace app\common\lib;


class Common
{
    public static function ArrayReGroup( $array )
    {
        $argList = func_get_args();
        $argNum = func_num_args();

        if ( !$array )
            return $array;

        if ( !isset( $argList[1] ) )
            return $array;

        if ( ( strpos( $argList[1], ',' ) !== false || strpos( $argList[1], '.' ) !== false ) && ( count( $argList ) == 2 || ( count( $argList ) == 3 && $argList[2] === true ) ) )
        {
            $path = preg_replace( '/\s/is', '', $argList[1] );
            $newArgList = array_merge( [ $array ], preg_split( '/[.,]/is', $path ) );

            if ( $argList[2] )
                $newArgList[] = $argList[2];

            $argList = $newArgList;
            $argNum = count( $argList );
        }

        $new = [];

        foreach ( $array as $val )
        {
            $tmp = &$new;
            for ( $i = 1; $i < $argNum; $i++ )
            {
                if ( $argList[$i] === true )
                    break;

                $n = $val[trim( $argList[$i] )];

                if ( !$tmp[$n] )
                    $tmp[$n] = [];

                $tmp = &$tmp[$n];
            }

            // 最后一个参数是true的情况下,强制索引最后一个
            if ( $argList[$i] === true )
                $tmp = $val;
            else
                $tmp[] = $val;
        }

        return $new;
    }

}