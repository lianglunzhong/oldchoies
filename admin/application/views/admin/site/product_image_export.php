<div>
	<div>
        <h1>产品图片导出</h1>
	</div>
	<form action="/admin/site/product/image_export" method="post" name="form" id="form"  enctype="multipart/form-data">
        <div>
			<div>
				<fieldset>
					<div>
						<div><span style="color:#FF0000" >注意： </span>一行一个SKU</div>
						<div><span>请输入产品SKU:</span><br />
							<textarea name="SKUARR"  cols="40" rows="20" ></textarea>
						</div>
					</div>
				</fieldset>
			</div>
        </div>
        <div>
			<div>
				<div>
					<span>
						<input  name="" value="导出" type="submit"/>
					</span>
				</div>
			</div>
        </div>
	</form>
</div>