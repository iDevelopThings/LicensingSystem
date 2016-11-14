<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 06/11/2016
 * Time: 4:46 PM
 *
 * @param     $message
 * @param int $httpStatus
 *
 * @return \Illuminate\Http\JsonResponse
 */
function msg($message, $httpStatus = 200)
{
	return response()->json(['message' => $message], $httpStatus);
}