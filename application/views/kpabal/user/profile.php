<!-- Content
		============================================= -->
		<style>
		.action_button , .business_record {
            display:inline-block;
        }
		</style>
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">

					<div class="row clearfix">

						<div class="col-md-9">
							<?php if(file_exists(PROJECT_AVATAR_DIR."/user_".$member->memberIdx."_1.jpg")) unlink(PROJECT_AVATAR_DIR."/user_".$member->memberIdx."_1.jpg");?>
							<img id="avatarimg" src="<?php if(file_exists(PROJECT_AVATAR_DIR."/user_".$member->memberIdx.".jpg")) echo ROOTPATH.PROJECT_AVATAR_DIR."/user_".$member->memberIdx.".jpg?".time() ; else echo ROOTPATH.PROJECT_AVATAR_DIR."/default.jpg";?>" class="alignleft img-circle img-thumbnail notopmargin nobottommargin" alt="Change your avatar!" title="Change your avatar!" style="max-width: 84px; cursor:pointer;">
							
							<div class="heading-block noborder">
								<h3><?php echo $member->user_id;?></h3>
								<span><?php echo $member->first_name.' '.$member->last_name;?></span>
							</div>

							<div class="clear"></div>

							<div class="row clearfix">

								<div class="col-lg-12">

									<div class="tabs tabs-alt clearfix" id="tabs-profile">

										<ul class="tab-nav clearfix">
											<li><a href="#tab-info"><i class="icon-user"></i> My Info</a></li>
											<li><a href="#tab-message"><i class="icon-envelope"></i> Messages<span class="badge badge-pill badge-secondary fright" style="margin-top: 3px;">5</span></a></li>
											<li><a href="#tab-points"><i class="icon-diamond"></i> Points History</a></li>
											<li><a href="#tab-shopping"><i class="icon-shop"></i> Shopping History</a></li>
											<li><a href="#tab-lotto"><i class="icon-gamepad"></i> Lotto History</a></li>
											<!-- <li><a href="#tab-payment"><i class="icon-dollar"></i> Payment History</a></li> -->
										</ul>

										<div class="tab-container">

											<div class="tab-content clearfix" id="tab-info">
												
												<form id="member_form" novalidate="novalidate">
													<input type="hidden" name="memberIdx" id="memberIdx" value="<?php if($member) echo $member->memberIdx;?>"/>
													<div class="form-row">
														<div class="form-group col-md-6">
															<label for="user_email">Email</label>
															<input type="email" class="form-control" id="user_email" name="user_email" placeholder="Email" readonly value="<?php if($member) echo $member->user_email;?>">
														</div>
														<div class="form-group col-md-3">
															<label for="first_name">FirstName</label>
															<input type="text" class="form-control" id="first_name" name="first_name" placeholder="FirstName" value="<?php if($member) echo $member->first_name;?>">
														</div>
														<div class="form-group col-md-3">
															<label for="last_name">LastName</label>
															<input type="text" class="form-control" id="last_name" name="last_name"  placeholder="LastName" value="<?php if($member) echo $member->last_name;?>">
														</div>
													</div>
													<div class="form-row">
														<div class="col-md-3 form-group">
															<label class="form-control-label">Gender</label>
															<select class="form-control m-input" name="gender">
																<option value="1"<?php if(($member) && ($member->gender == 1)) echo " selected";?>>Male</option> 
																<option value="0"<?php if(($member) && ($member->gender == 0)) echo " selected";?>>Female</option>
															</select>
														</div>
														<div class="col-md-6 form-group">
															<label for="">DOB</label>
															<input type="text" value="<?php if($member) echo date("m/d/Y", strtotime($member->dob));?>" class="form-control tleft default"  id="dob" name="dob" placeholder="MM/DD/YYYY">
														</div>
													</div>
													<div class="form-group">
														<label for="address">Address</label>
														<input type="text" name="address" class="form-control" id="address" placeholder="Enter Address" value="<?php if($member) echo $member->address;?>">
													</div>
													<div class="form-group">
														<label for="street">Street</label>
														<input type="text" class="form-control" name="street" placeholder="Enter street" id="street" value="<?php if($member) echo $member->street;?>">
													</div>
													<div class="form-row">
														<div class="form-group col-md-6">
															<label for="inputCity">City</label>
															<input type="text" class="form-control"  name="city" placeholder="Enter city" value="<?php if($member) echo $member->city;?>">
														</div>
														<div class="form-group col-md-4">
															<label for="stateIdx">State</label>
															<select id="stateIdx" class="form-control"  name="stateIdx">
															<option value="">Select</option>
															<?php foreach($states as $state) {?>
																<option value="<?=$state->stateIdx?>"<?php if(($member) && ($member->stateIdx == $state->stateIdx)) echo " selected";?>><?=$state->stateName?></option>
															<?php }?>
															</select>
														</div>
														<div class="form-group col-md-2">
															<label for="postal_code">Postal Code</label>
															<input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Enter postal code" value="<?php if($member) echo $member->postal_code;?>">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-6">
															<label for="phone">Phone Number</label>
															<input type="text" class="form-control"  id="phone" name="phone" placeholder="Enter phone number" value="<?php if($member) echo $member->phone;?>">
														</div>
														<div class="form-group col-md-6">
															<label for="mobile">Mobile Number</label>
															<input type="text" class="form-control" name="mobile" placeholder="Enter mobile number" value="<?php if($member) echo $member->mobile;?>">
														</div>
													</div>
													<button type="submit" class="btn btn-primary">Update</button>
												</form>
											</div>
											<div class="tab-content clearfix" id="tab-message">
												<div class="row topmargin-sm clearfix">
													<div class="col-12 bottommargin-sm">
                                                        <div class="container clearfix">
                                                            <div class="table-responsive">
                                                                <table id="datatable_message" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Message</th>
                                                                            <th>Sender</th>
                                                                            <th>date</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>#</td>
                                                                            <td>해외에서 꼭 필요한 스마트폰 어플들! [강추!]</td>
                                                                            <td>kpabal</td>
                                                                            <td>2018/08/09</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>Dear Customer, I am luo</td>
                                                                            <td>LuoTong</td>
                                                                            <td>2018/08/09</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td>Dear Customer, I am luo</td>
                                                                            <td>LuoTong</td>
                                                                            <td>2018/08/09</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td>Dear Customer, I am luo</td>
                                                                            <td>LuoTong</td>
                                                                            <td>2018/08/09</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>4</td>
                                                                            <td>Dear Customer, I am luo</td>
                                                                            <td>LuoTong</td>
                                                                            <td>2018/08/09</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
													</div>
												</div>
											</div>
											<div class="tab-content clearfix" id="tab-points">
                                                <div class="row topmargin-sm clearfix">
													<div class="col-12 bottommargin-sm">
                                                        <div class="container clearfix">
                                                            <div class="table-responsive">
                                                                <table id="datatable_points" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Date</th>
                                                                            <th>History</th>
                                                                            <th>amount</th>
                                                                            <!--<th>target</th>-->
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach($points as $point){
                                                                        ?>
                                                                        <tr>
                                                                            <td><?=$point['date']?></td>
                                                                            <td><?=$point['type']?></td>
                                                                            <td><?=$point['amount']?></td>
                                                                            <!--<td>kpabal</td>-->
                                                                        </tr>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
													</div>
												</div>
											</div>
                                            <div class="tab-content clearfix" id="tab-shopping">
												<div class="row topmargin-sm clearfix">
													<div class="col-12 bottommargin-sm">
                                                        <div class="container clearfix">
                                                            <div class="row content_container">
                                                                <div class="col-sm-12">
                                                                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                                      <li class="nav-item">
                                                                        <a class="nav-link active" id="order-tab" data-toggle="tab" href="#" role="tab" aria-selected="false">Order History</a>
                                                                      </li>
                                                                      <li class="nav-item">
                                                                        <a class="nav-link" id="payment-tab" data-toggle="tab" href="#" role="tab" aria-selected="false">Payment History</a>
                                                                      </li>
                                                                    </ul>
                                                                    <div class="tab-content" id="mall_list">
                                                                      <div class="tab-pane fade show active" role="tabpanel" id="content_table">
                                                                      </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
													</div>
												</div>
											</div>
											<div class="tab-content clearfix" id="tab-lotto">
												<div class="row topmargin-sm clearfix">
													<div class="col-12 bottommargin-sm">
                                                        <div class="container clearfix">
                                                            <div class="row content_container1">
                                                                <div class="col-sm-12">
                                                                  <ul class="nav nav-tabs" id="myTab1" role="tablist">
                                                                      <li class="nav-item">
                                                                        <a class="nav-link active" id="order-tab1" data-toggle="tab" href="#" role="tab" aria-selected="false">Order History</a>
                                                                      </li>
                                                                      <li class="nav-item">
                                                                        <a class="nav-link" id="payment-tab1" data-toggle="tab" href="#" role="tab" aria-selected="false">Payment History</a>
                                                                      </li>
                                                                    </ul>
                                                                    <div class="tab-content" id="mall_list">
                                                                      <div class="tab-pane fade show active" role="tabpanel" id="content_table1">
                                                                        <div id="div_lotto_order">
                                                                          <table id="datatable_lotto_order" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Date</th>
                                                                                    <th>Game Type</th>
                                                                                    <th>amount</th>
                                                                                    <!--<th>target</th>-->
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                foreach($lotto_order as $order){
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?=$order['orderDate']?></td>
                                                                                    <td><?=$order['gameType']?></td>
                                                                                    <td>$<?=$order['totalAmount']?></td>
                                                                                    <!--<td>kpabal</td>-->
                                                                                </tr>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                        </div>
                                                                        <div id="div_lotto_payment" style="display:none;">
                                                                          <table id="datatable_lotto_payment" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Date</th>
                                                                                    <th>Game Type</th>
                                                                                    <th>amount</th>
                                                                                    <!--<th>target</th>-->
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                foreach($lotto_payment as $payment){
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?=$payment['paymentDate']?></td>
                                                                                    <td><?=$payment['paymentReason']?></td>
                                                                                    <td>$<?=$payment['paymentAmount']?></td>
                                                                                    <!--<td>kpabal</td>-->
                                                                                </tr>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table></div>
                                                                      </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
													</div>
												</div>
											</div>
										</div>

									</div>

								</div>

							</div>

						</div>

						<div class="w-100 line d-block d-md-none"></div>

						<div class="col-md-3 clearfix">

							<div class="fancy-title topmargin title-border">
								<h4>About Me</h4>
							</div>
							<i class="i-plain i-small icon-edit float-right edDesc"></i>
							<p id="descField"><?php if($member) echo $member->member_about;?></p>
							<div id="descEtField" class="display-none">
								<textarea  rows="4" cols="30" class="required sm-form-control input-block-level short-textarea">
									<?php if($member) echo $member->member_about;?>
								</textarea>
								<a href="javascript:;" id="aboutCancel" class="pull-right"><i class="i-plain i-small icon-remove"></i></a>
								<a href="javascript:;" id="aboutSubmit" class="pull-right"><i class="i-plain i-small icon-ok"></i></a>

							</div>
							
							<div class="fancy-title topmargin title-border">
								<h4>Social Profiles</h4>
							</div>

							<a href="#" class="social-icon si-facebook si-small si-rounded si-light" title="Facebook">
								<i class="icon-facebook"></i>
								<i class="icon-facebook"></i>
							</a>

							<a href="#" class="social-icon si-gplus si-small si-rounded si-light" title="Google+">
								<i class="icon-gplus"></i>
								<i class="icon-gplus"></i>
							</a>

							<a href="#" class="social-icon si-dribbble si-small si-rounded si-light" title="Dribbble">
								<i class="icon-dribbble"></i>
								<i class="icon-dribbble"></i>
							</a>

							<a href="#" class="social-icon si-flickr si-small si-rounded si-light" title="Flickr">
								<i class="icon-flickr"></i>
								<i class="icon-flickr"></i>
							</a>

							<a href="#" class="social-icon si-linkedin si-small si-rounded si-light" title="LinkedIn">
								<i class="icon-linkedin"></i>
								<i class="icon-linkedin"></i>
							</a>

							<a href="#" class="social-icon si-twitter si-small si-rounded si-light" title="Twitter">
								<i class="icon-twitter"></i>
								<i class="icon-twitter"></i>
							</a>

						</div>

					</div>

				</div>

			</div>

		</section><!-- #content end -->
		<input type="file" id="upload_avatar" accept=".gif,.jpg,.jpeg,.png" style="display: none;">