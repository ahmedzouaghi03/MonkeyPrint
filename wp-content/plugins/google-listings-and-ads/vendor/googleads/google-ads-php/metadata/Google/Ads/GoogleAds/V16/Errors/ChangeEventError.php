<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v16/errors/change_event_error.proto

namespace GPBMetadata\Google\Ads\GoogleAds\V16\Errors;

class ChangeEventError
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();
        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�
8google/ads/googleads/v16/errors/change_event_error.protogoogle.ads.googleads.v16.errors"�
ChangeEventErrorEnum"�
ChangeEventError
UNSPECIFIED 
UNKNOWN
START_DATE_TOO_OLD
CHANGE_DATE_RANGE_INFINITE
CHANGE_DATE_RANGE_NEGATIVE
LIMIT_NOT_SPECIFIED
INVALID_LIMIT_CLAUSEB�
#com.google.ads.googleads.v16.errorsBChangeEventErrorProtoPZEgoogle.golang.org/genproto/googleapis/ads/googleads/v16/errors;errors�GAA�Google.Ads.GoogleAds.V16.Errors�Google\\Ads\\GoogleAds\\V16\\Errors�#Google::Ads::GoogleAds::V16::Errorsbproto3'
        , true);
        static::$is_initialized = true;
    }
}

