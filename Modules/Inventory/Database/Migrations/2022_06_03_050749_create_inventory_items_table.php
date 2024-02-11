<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('Item_Code', 150)->nullable();
            $table->foreignId('CompanyID')->nullable();
            $table->foreign('CompanyID')->references('id')->on('settings_companies')->onDelete('cascade');
            $table->string('item_name', 255)->nullable();
            $table->longText('Item_description')->nullable();
            $table->string('Inventory_code',255);
            $table->string('image')->nullable();
            $table->string('item_group',11)->nullable();
            $table->foreignId('stock_uom')->nullable();
            $table->foreign('stock_uom')->references('id')->on('inventory_uom')->onDelete('restrict');
            $table->boolean('allow_alternative_item')->nullable();
            $table->boolean('is_purchase_item')->nullable();
            $table->boolean('is_stock_item')->nullable();
            $table->boolean('is_manufacturing_item')->nullable();
            $table->boolean('is_seafood_item')->nullable();
            $table->boolean('is_by_product')->nullable();
            $table->boolean('is_fixed_asset')->nullable();
            $table->boolean('is_sf_raw_material')->default(false);
            $table->string('asset_category')->nullable();
            $table->string('asset_item_short_code',5)->nullable();
            $table->boolean('is_auto_create_assets')->nullable();
            $table->string('asset_naming_series',150)->nullable();
            $table->decimal('opening_stock',10)->nullable();
            $table->string('valuation_rate',255)->nullable();
            $table->string('standard_rate',255)->nullable();
            $table->integer('BrandID')->nullable();
            $table->integer('shelf_life_in_days')->nullable();
            $table->foreignId('weight_uom')->nullable();
            $table->foreign('weight_uom')->references('id')->on('inventory_uom')->onDelete('restrict');
            $table->float('avg_weight_per_unit')->nullable();
            $table->boolean('default_material_request_type')->nullable();
            $table->decimal('over_purchase_receipt_allowance',10)->nullable();
            $table->decimal('over_billing_allowance',10)->nullable();
            $table->integer('valuation_method')->nullable();
            $table->integer('default_warranty_period_days')->nullable();
            $table->boolean('create_new_batch')->nullable();
            $table->boolean('has_serial_no')->nullable();
            $table->boolean('has_batch_no')->nullable();
            $table->string('batch_number_series')->nullable();
            $table->boolean('has_variants')->nullable();
            $table->boolean('create_unit_batch')->nullable();
            $table->foreignId('purchase_uom')->nullable();
            $table->foreign('purchase_uom')->references('id')->on('inventory_uom')->onDelete('restrict');
            $table->decimal('min_order_qty',10)->nullable();
            $table->decimal('safety_stock',10)->nullable();
            $table->integer('lead_time_days')->nullable();
            $table->decimal('last_purchase_rate',10)->nullable();
            $table->boolean('is_inspection_required_before_receive')->nullable();
            $table->boolean('is_inspection_required_before_delivery')->nullable();
            $table->foreignId('before_receive_rule')->nullable();
            $table->foreign('before_receive_rule')->references('id')->on('quality_qc_rule')->onDelete('restrict');
            $table->foreignId('before_delivery_rule')->nullable();
            $table->foreign('before_delivery_rule')->references('id')->on('quality_qc_rule')->onDelete('restrict');
            $table->integer('default_bom')->nullable();
            $table->boolean('is_customer_provided_item')->nullable();
            $table->string('default_item_manufacturer',140)->nullable();
            $table->string('default_manufacturer_part_no',140)->nullable();
            $table->integer('show_in_website')->nullable();
            $table->integer('show_variant_in_website')->nullable();
            $table->text('route')->nullable();
            $table->integer('weightage')->nullable();
            $table->string('slideshow',140)->nullable();
            $table->text('website_image')->nullable();
            $table->string('thumbnail',140)->nullable();
            $table->string('website_warehouse',140)->nullable();
            $table->longText('web_long_description')->nullable();
            $table->longText('website_content')->nullable();
            $table->decimal('total_projected_qty')->nullable();
            $table->integer('publish_in_hub')->nullable();
            $table->string('hub_category_to_publish')->nullable();
            $table->string('hub_warehouse')->nullable();
            $table->foreignId('ReceiveGrade')->nullable();
            $table->foreign('ReceiveGrade')->references('id')->on('sf_fish_grades')->onDelete('restrict');
            $table->string('ReceiveSizeVarient')->nullable();
            $table->foreignId('ReceivePresentation')->nullable();
            $table->foreign('ReceivePresentation')->references('id')->on('sf_presentation_type')->onDelete('restrict');
            $table->foreignId('rm_species')->nullable();
            $table->foreign('rm_species')->references('id')->on('sf_fish_species')->onDelete('restrict');
            $table->integer('list_index')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('modified_by', 20)->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_items');
    }
};
