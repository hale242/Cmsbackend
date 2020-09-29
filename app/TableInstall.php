<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class TableInstall extends Model
{
    public static function CreateTable($name_module)
    {
        if ($name_module == 'News') {
            Schema::create('news', function ($table) {
                $table->Increments('news_id')->comment('ID อ้างอิงข่าว');
                $table->string('news_image', 255)->charset('utf8')->nullable()->comment('รูปหน้าปกข่าว');
                $table->string('news_image_alt', 255)->charset('utf8')->nullable();
                $table->string('news_seo_title', 255)->charset('utf8')->nullable()->comment('หัวข้อ SEO');
                $table->string('news_seo_keyword', 255)->charset('utf8')->nullable()->comment('คีย์ SEO');
                $table->string('news_seo_description', 255)->charset('utf8')->nullable()->comment('คำอธิบาย SEO');
                $table->string('news_url_slug', 255)->charset('utf8')->nullable()->comment('เป็น url สำหรับการแสดงผล หรือ rewrite url');
                $table->integer('news_sort_order')->nullable();
                $table->tinyInteger('news_language_lock_type')->nullable()->comment('0=ล็อกภาษา 1=เลือกตามประเภทภาษา');
                $table->date('news_date_set')->nullable();
                $table->date('news_date_end')->nullable();
                $table->tinyInteger('news_status')->nullable();
                $table->timestamps();
            });
            Schema::create('news_category', function ($table) {
                $table->Increments('news_category_id')->comment('ID อ้างอิงหมวดหมู่ข่าว');
                $table->string('news_category_seo_title', 255)->charset('utf8')->nullable();
                $table->string('news_category_seo_keyword', 255)->charset('utf8')->nullable();
                $table->string('news_category_seo_description', 255)->charset('utf8')->nullable();
                $table->string('news_category_url_slug', 255)->charset('utf8')->nullable();
                $table->tinyInteger('news_category_status')->nullable()->comment('0=ปิด 1=เปิด');
                $table->tinyInteger('news_status')->nullable();
                $table->timestamps();
            });

            Schema::create('news_category_details', function ($table) {
                $table->Increments('news_category_details_id');
                $table->Integer('news_category_id')->unsigned();
                $table->foreign('news_category_id')->references('news_category_id')->on('news_category');
                $table->Integer('languages_id')->unsigned();
                $table->foreign('languages_id')->references('languages_id')->on('languages');
                $table->string('news_category_details_languages_code', 255)->charset('utf8')->nullable()->comment('รหัสภาษา');
                $table->string('news_category_details_name', 255)->charset('utf8')->nullable()->commemnt('ชื่อหมวดหมู่');
                $table->text('news_category_details_details')->charset('utf8')->nullable()->comment('รายละเอียดอื่นๆของหมวดหมู่');
                $table->string('news_category_details_seo_title', 255)->charset('utf8')->nullable();
                $table->string('news_category_details_seo_keyword', 255)->charset('utf8')->nullable();
                $table->string('news_category_details_seo_description', 255)->charset('utf8')->nullable();
                $table->tinyInteger('news_category_details_seo_type')->nullable()->comment('0=ใช้ SEO หลัก 1= ใช้ SEO ตามภาษา');
                $table->tinyInteger('news_category_details_status')->nullable()->comment('0=ปิด 1=เปิด');
                $table->timestamps();
            });
            Schema::create('news_details', function ($table) {
                $table->Increments('news_details_id');
                $table->Integer('news_id')->unsigned();
                $table->foreign('news_id')->references('news_id')->on('news');
                $table->Integer('languages_id')->unsigned();
                $table->foreign('languages_id')->references('languages_id')->on('languages');
                $table->string('news_details_languages_code', 45)->charset('utf8')->nullable()->comment('รหัสภาษา เช่น th/en/cn');
                $table->string('news_details_image', 255)->charset('utf8')->nullable()->commemnt('รูปภาพปกของข่าว');
                $table->string('news_details_image_alt', 255)->charset('utf8')->nullable();
                $table->string('news_details_subject', 255)->charset('utf8')->nullable()->comment('หัวข้อข่าว');
                $table->text('news_details_title')->charset('utf8')->nullable();
                $table->text('news_details_description')->charset('utf8')->nullable();
                $table->tinyInteger('news_details_image_type')->nullable()->comment('0=ใช้รูปหลักเป็นปก 1=ใช้รูปตามเนื้อข่าวเป็นปก (แยกตามภาษา)');
                $table->string('news_details_seo_title', 255)->charset('utf8')->nullable();
                $table->string('news_details_seo_keyword', 255)->charset('utf8')->nullable();
                $table->string('news_details_seo_description', 255)->charset('utf8')->nullable();
                $table->tinyInteger('news_details_seo_type')->nullable();
                $table->string('news_details_og_title', 255)->charset('utf8')->nullable();
                $table->string('news_details_og_description', 255)->charset('utf8')->nullable();
                $table->string('news_details_og_url', 255)->charset('utf8')->nullable();
                $table->string('news_details_og_site_name', 255)->charset('utf8')->nullable();
                $table->string('news_details_og_image', 255)->charset('utf8')->nullable();
                $table->tinyInteger('news_details_status')->nullable();
                $table->timestamps();
            });
            Schema::create('news_gallery', function ($table) {
                $table->Increments('news_gallery_id');
                $table->Integer('news_id')->unsigned();
                $table->foreign('news_id')->references('news_id')->on('news');
                $table->string('news_gallery_image_gall', 255)->charset('utf8')->nullable();
                $table->text('news_gallery_details')->charset('utf8')->nullable();
                $table->tinyInteger('news_gallery_type')->nullable();
                $table->tinyInteger('news_gallery_status')->nullable();
                $table->timestamps();
            });
            Schema::create('news_has_news_category', function ($table) {
                $table->Increments('news_has_news_category_id');
                $table->Integer('news_id')->unsigned();
                $table->foreign('news_id')->references('news_id')->on('news');
                $table->Integer('news_category_id')->unsigned();
                $table->foreign('news_category_id')->references('news_category_id')->on('news_category');
                $table->tinyInteger('news_has_news_category_status')->nullable();
                $table->timestamps();
            });
            Schema::create('news_tag', function ($table) {
                $table->Increments('news_tag_id');
                $table->string('news_tag_name', 255)->charset('utf8')->nullable();
                $table->string('news_tag_details', 255)->charset('utf8')->nullable();
                $table->tinyInteger('news_tag_status')->nullable();
                $table->timestamps();
            });
            Schema::create('news_has_news_tag', function ($table) {
                $table->Increments('news_has_news_tag_id');
                $table->Integer('news_id')->unsigned();
                $table->foreign('news_id')->references('news_id')->on('news');
                $table->Integer('news_tag_id')->unsigned();
                $table->foreign('news_tag_id')->references('news_tag_id')->on('news_tag');
                $table->string('news_has_news_tag_name', 255)->charset('utf8')->nullable();
                $table->tinyInteger('news_has_news_tag_status')->nullable();
                $table->timestamps();
            });
        }
        if ($name_module == 'Event') {
            Schema::create('event', function ($table) {
                $table->Increments('event_id')->comment('ID อ้างอิงข่าว');
                $table->string('event_image', 255)->charset('utf8')->nullable()->comment('รูปหน้าปกข่าว');
                $table->string('event_image_alt', 255)->charset('utf8')->nullable();
                $table->string('event_seo_title', 255)->charset('utf8')->nullable()->comment('หัวข้อ SEO');
                $table->string('event_seo_keyword', 255)->charset('utf8')->nullable()->comment('คีย์ SEO');
                $table->string('event_seo_description', 255)->charset('utf8')->nullable()->comment('คำอธิบาย SEO');
                $table->string('event_url_slug', 255)->charset('utf8')->nullable()->comment('เป็น url สำหรับการแสดงผล หรือ rewrite url');
                $table->integer('event_sort_order')->nullable();
                $table->tinyInteger('event_language_lock_type')->nullable()->comment('0=ล็อกภาษา 1=เลือกตามประเภทภาษา');
                $table->date('event_date_set')->nullable();
                $table->date('event_date_end')->nullable();
                $table->tinyInteger('event_status')->nullable();
                $table->timestamps();
            });
            Schema::create('event_category', function ($table) {
                $table->Increments('event_category_id')->comment('ID อ้างอิงหมวดหมู่ข่าว');
                $table->string('event_category_seo_title', 255)->charset('utf8')->nullable();
                $table->string('event_category_seo_keyword', 255)->charset('utf8')->nullable();
                $table->string('event_category_seo_description', 255)->charset('utf8')->nullable();
                $table->string('event_category_url_slug', 255)->charset('utf8')->nullable();
                $table->tinyInteger('event_category_status')->nullable()->comment('0=ปิด 1=เปิด');
                $table->tinyInteger('event_status')->nullable();
                $table->timestamps();
            });

            Schema::create('event_category_details', function ($table) {
                $table->Increments('event_category_details_id');
                $table->Integer('event_category_id')->unsigned();
                $table->foreign('event_category_id')->references('event_category_id')->on('event_category');
                $table->Integer('languages_id')->unsigned();
                $table->foreign('languages_id')->references('languages_id')->on('languages');
                $table->string('event_category_details_languages_code', 255)->charset('utf8')->nullable()->comment('รหัสภาษา');
                $table->string('event_category_details_name', 255)->charset('utf8')->nullable()->commemnt('ชื่อหมวดหมู่');
                $table->text('event_category_details_details')->charset('utf8')->nullable()->comment('รายละเอียดอื่นๆของหมวดหมู่');
                $table->string('event_category_details_seo_title', 255)->charset('utf8')->nullable();
                $table->string('event_category_details_seo_keyword', 255)->charset('utf8')->nullable();
                $table->string('event_category_details_seo_description', 255)->charset('utf8')->nullable();
                $table->tinyInteger('event_category_details_seo_type')->nullable()->comment('0=ใช้ SEO หลัก 1= ใช้ SEO ตามภาษา');
                $table->tinyInteger('event_category_details_status')->nullable()->comment('0=ปิด 1=เปิด');
                $table->timestamps();
            });
            Schema::create('event_details', function ($table) {
                $table->Increments('event_details_id');
                $table->Integer('event_id')->unsigned();
                $table->foreign('event_id')->references('event_id')->on('event');
                $table->Integer('languages_id')->unsigned();
                $table->foreign('languages_id')->references('languages_id')->on('languages');
                $table->string('event_details_languages_code', 45)->charset('utf8')->nullable()->comment('รหัสภาษา เช่น th/en/cn');
                $table->string('event_details_image', 255)->charset('utf8')->nullable()->commemnt('รูปภาพปกของข่าว');
                $table->string('event_details_image_alt', 255)->charset('utf8')->nullable();
                $table->string('event_details_subject', 255)->charset('utf8')->nullable()->comment('หัวข้อข่าว');
                $table->text('event_details_title')->charset('utf8')->nullable();
                $table->text('event_details_description')->charset('utf8')->nullable();
                $table->tinyInteger('event_details_image_type')->nullable()->comment('0=ใช้รูปหลักเป็นปก 1=ใช้รูปตามเนื้อข่าวเป็นปก (แยกตามภาษา)');
                $table->string('event_details_seo_title', 255)->charset('utf8')->nullable();
                $table->string('event_details_seo_keyword', 255)->charset('utf8')->nullable();
                $table->string('event_details_seo_description', 255)->charset('utf8')->nullable();
                $table->tinyInteger('event_details_seo_type')->nullable();
                $table->string('event_details_og_title', 255)->charset('utf8')->nullable();
                $table->string('event_details_og_description', 255)->charset('utf8')->nullable();
                $table->string('event_details_og_url', 255)->charset('utf8')->nullable();
                $table->string('event_details_og_site_name', 255)->charset('utf8')->nullable();
                $table->string('event_details_og_image', 255)->charset('utf8')->nullable();
                $table->tinyInteger('event_details_status')->nullable();
                $table->timestamps();
            });
            Schema::create('event_gallery', function ($table) {
                $table->Increments('event_gallery_id');
                $table->Integer('event_id')->unsigned();
                $table->foreign('event_id')->references('event_id')->on('event');
                $table->string('event_gallery_image_gall', 255)->charset('utf8')->nullable();
                $table->text('event_gallery_details')->charset('utf8')->nullable();
                $table->tinyInteger('event_gallery_type')->nullable();
                $table->tinyInteger('event_gallery_status')->nullable();
                $table->timestamps();
            });
            Schema::create('event_has_event_category', function ($table) {
                $table->Increments('event_has_event_category_id');
                $table->Integer('event_id')->unsigned();
                $table->foreign('event_id')->references('event_id')->on('event');
                $table->Integer('event_category_id')->unsigned();
                $table->foreign('event_category_id')->references('event_category_id')->on('event_category');
                $table->tinyInteger('event_has_event_category_status')->nullable();
                $table->timestamps();
            });
            Schema::create('event_tag', function ($table) {
                $table->Increments('event_tag_id');
                $table->string('event_tag_name', 255)->charset('utf8')->nullable();
                $table->string('event_tag_details', 255)->charset('utf8')->nullable();
                $table->tinyInteger('event_tag_status')->nullable();
                $table->timestamps();
            });
            Schema::create('event_has_event_tag', function ($table) {
                $table->Increments('event_has_event_tag_id');
                $table->Integer('event_id')->unsigned();
                $table->foreign('event_id')->references('event_id')->on('event');
                $table->Integer('event_tag_id')->unsigned();
                $table->foreign('event_tag_id')->references('event_tag_id')->on('event_tag');
                $table->string('event_has_event_tag_name', 255)->charset('utf8')->nullable();
                $table->tinyInteger('event_has_event_tag_status')->nullable();
                $table->timestamps();
            });
        }
    }
    public static function DropTable($name_module)
    {
        if ($name_module == 'News') {
            Schema::disableForeignKeyConstraints();
            Schema::drop('news');
            Schema::drop('news_category');
            Schema::drop('news_category_details');
            Schema::drop('news_details');
            Schema::drop('news_gallery');
            Schema::drop('news_has_news_category');
            Schema::drop('news_has_news_tag');
            Schema::drop('news_tag');
        }
        if ($name_module == 'Event') {
            Schema::disableForeignKeyConstraints();
            Schema::drop('event');
            Schema::drop('event_category');
            Schema::drop('event_category_details');
            Schema::drop('event_details');
            Schema::drop('event_gallery');
            Schema::drop('event_has_event_category');
            Schema::drop('event_has_event_tag');
            Schema::drop('event_tag');
        }
    }
}
