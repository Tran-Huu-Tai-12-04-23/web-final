<div class="w-100 start justify-content-between">
	<h1 class='cl fs-32 mb-4'>Manager Video</h1>
	<div class="w75 end">
		<div class="bt-primary br-primary bg-second center " id='btn-select-videos'>
			<i class='bx bx-check fs-24 cl mr-2' ></i>	
			<span>
			Select Videos
			</span>	
		</div>
		<div class="bt-primary br-primary bg-second center hidden " id='btn-cancel-select-videos'>
			<i class='bx bx-x fs-24 cl mr-2' ></i>	
			<span>
			Cancel Select
			</span>	
		</div>
		<div class=" end hidden ml-4" id='action-all-videos'>
			<div class='bt-primary cl mr-4 hover_close bg-second br-primary fs-14 ' id='bt-remove-all-video'  style='color: #000'><i class='bx bx-trash-alt fs-24 mr-2' ></i>Remove Items Selected</div>
		</div>
	</div>
</div>

<div class="w-100 mt-5">
	<div class="header_fixed br-primary bg-second fs-16">
		<table >
			<thead >
					<tr>
						<th class='' style='padding-left: 2rem;padding-right: 2rem'>
						<div class="checkbox-wrapper-12 mr-2 select-all-show-video hidden parent-suggest"  style='float:left;  vertical-align: middle !important; width: unset!important; height: unset'>
							<div class="cbx" style='width: 1rem; height: .5rem'>
										<input class="cbx-12 " value='' id='select-all-videos' name='user-all-select' type="checkbox">
										<label for="cbx-12"></label>
										<svg width="15" height="14" viewBox="0 0 15 14" fill="none">
										<path d="M2 8.36364L6.23077 12L13 2"></path>
										</svg>
									</div>
									<svg xmlns="http://www.w3.org/2000/svg" version="1.1">
										<defs>
										<filter id="goo-12">
											<feGaussianBlur in="SourceGraphic" stdDeviation="4" result="blur"></feGaussianBlur>
											<feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 22 -7" result="goo-12"></feColorMatrix>
											<feBlend in="SourceGraphic" in2="goo-12"></feBlend>
										</filter>
										</defs>
									</svg>
									<div class="child-suggest fs-12" style='top: -.8rem'>
									Select all videos
									</div>
									</div>
							S No.
						</th>
						<th>Thumbnails</th>
						<th>Title</th>
						<th>Description</th>
						<th>Upload Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id='table-manager-videos' style='margin-top: 2rem'>
				</tbody>
			</table>
		
		</div>
</div>


<div class="wrapper-modal-admin-remove-video position-fixed hidden" style='top:0; left: 0; bottom: 0;right: 0;
background-color: rgba(0,0,0,.3); z-index: 1000000000'>
	<div class="modal-block-video position-absolute br-primary p-4 box-shadow" style='color: #000;background-color: #252c48;backdrop-filter: 2rem; top: 2rem; left: 50%; transform:translateX(-50%); min-width: 40rem; z-index: 1000000000'>
		<h1 class='fs-18 cl'>
			Please , Confirmation form!!
		</h1>
		<div class="mt-4" style='border-top: 1px solid #ccc'>
		</div>
		<h5 class='fs-16 cl mt-4'>
			Are you sure remove this video  
		</h5>
		<div class=" mt-4 mb-4" style='border-top: 1px solid #ccc'>
		</div>
		<div class="w-100 end mt-4">
			<div class="bt-primary  bg-transparent br-primary hover_close fs-16 h-30px  " id='btn-confirm-soft-delete-video'>Remove</div>
			<div class="bt-primary ml-3 br-primary bg-second  fs-16 h-30px btn-cancel">Cancel</div>
		</div>
	</div>
</div>