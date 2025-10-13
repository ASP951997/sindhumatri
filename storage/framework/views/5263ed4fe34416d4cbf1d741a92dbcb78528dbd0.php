<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <?php if(adminAccessRoute(config('role.dashboard.access.view'))): ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo e(route('admin.dashboard')); ?>" aria-expanded="false">
                            <i data-feather="home" class="feather-icon text-indigo"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Dashboard'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(adminAccessRoute(array_merge(config('role.plan.access.view'), config('role.plan_sold.access.view')))): ?>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu"><?php echo app('translator')->get('Manage Package'); ?></span></li>
                    <?php if(adminAccessRoute(config('role.plan.access.view'))): ?>
                        <li class="sidebar-item <?php echo e(menuActive(['admin.planList','admin.planCreate','admin.planEdit*'],3)); ?>">
                            <a class="sidebar-link" href="<?php echo e(route('admin.planList')); ?>" aria-expanded="false">
                                <i class="fas fa-cubes text-info"></i>
                                <span class="hide-menu"><?php echo app('translator')->get('Package List'); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if(adminAccessRoute(config('role.plan_sold.access.view'))): ?>
                        <li class="sidebar-item <?php echo e(menuActive(['admin.sold.planList','admin.soldPlan.search'],3)); ?>">
                            <a class="sidebar-link" href="<?php echo e(route('admin.sold.planList')); ?>" aria-expanded="false">
                                <i class="fas fa-cart-arrow-down text-purple"></i>
                                <span class="hide-menu"><?php echo app('translator')->get('Sold Packages'); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>



                <?php if(adminAccessRoute(config('role.user_management.access.view'))): ?>
                    
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu"><?php echo app('translator')->get('Manage User'); ?></span></li>

                    <li class="sidebar-item <?php echo e(menuActive(['admin.users','admin.users.search','admin.user-edit*','admin.send-email*','admin.user*'],3)); ?>">
                        <a class="sidebar-link" href="<?php echo e(route('admin.users')); ?>" aria-expanded="false">
                            <i class="fas fa-users text-dark"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('All User'); ?></span>
                        </a>
                    </li>


                    <li class="sidebar-item <?php echo e(menuActive(['admin.onBehalfList','admin.onBehalfCreate','admin.onBehalfEdit*','admin.hairColorList','admin.hairColorCreate','admin.hairColorEdit*','admin.complexionList','admin.complexionCreate','admin.complexionEdit*','admin.bodyTypeList','admin.bodyTypeCreate','admin.bodyTypeEdit*','admin.bodyArtList','admin.bodyArtCreate','admin.bodyArtEdit*','admin.maritalStatusList','admin.maritalStatusCreate','admin.maritalStatusEdit*','admin.familyValueList','admin.familyValueCreate','admin.familyValueEdit*','admin.ethnicityList','admin.ethnicityCreate','admin.ethnicityEdit*','admin.personalValueList','admin.personalValueCreate','admin.communityValueList','admin.communityValueCreate','admin.communityValueEdit*','admin.personalValueEdit*','admin.politicalViewList','admin.politicalViewCreate','admin.politicalViewEdit*','admin.religiousServiceList','admin.religiousServiceCreate','admin.religiousServiceEdit*','admin.affectionForList','admin.affectionForCreate','admin.affectionForEdit*','admin.humorList','admin.humorCreate','admin.humorEdit*','admin.religionList','admin.religionCreate','admin.religionEdit*','admin.casteList','admin.casteCreate','admin.casteEdit*','admin.subCasteList','admin.subCasteCreate','admin.subCasteEdit*','admin.countryList','admin.countryCreate','admin.countryEdit*','admin.stateList','admin.stateCreate', 'admin.state.search','admin.stateEdit*','admin.cityList', 'admin.city.search','admin.cityCreate','admin.cityEdit*'],3)); ?>">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-cogs text-red"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Profile Attributes'); ?></span>
                        </a>
                        <ul aria-expanded="false"
                            class="collapse first-level base-level-line <?php echo e(menuActive(['admin.onBehalfList','admin.onBehalfCreate','admin.onBehalfEdit*','admin.hairColorList','admin.hairColorCreate','admin.hairColorEdit*','admin.complexionList','admin.complexionCreate','admin.complexionEdit*','admin.bodyTypeList','admin.bodyTypeCreate','admin.bodyTypeEdit*','admin.bodyArtList','admin.bodyArtCreate','admin.bodyArtEdit*','admin.maritalStatusList','admin.maritalStatusCreate','admin.maritalStatusEdit*','admin.familyValueList','admin.familyValueCreate','admin.familyValueEdit*', 'admin.ethnicityList','admin.ethnicityCreate','admin.ethnicityEdit*','admin.personalValueList','admin.personalValueCreate','admin.personalValueEdit*','admin.communityValueList','admin.communityValueCreate','admin.communityValueEdit*','admin.politicalViewList','admin.politicalViewCreate','admin.politicalViewEdit*','admin.religionList','admin.religionCreate','admin.religionEdit*','admin.religiousServiceList','admin.religiousServiceCreate','admin.religiousServiceEdit*','admin.affectionForList','admin.affectionForCreate','admin.affectionForEdit*','admin.humorList','admin.humorCreate','admin.humorEdit*','admin.casteList','admin.casteCreate','admin.casteEdit*','admin.subCasteList','admin.subCasteCreate','admin.subCasteEdit*','admin.countryList','admin.countryCreate','admin.countryEdit*','admin.stateList','admin.stateCreate', 'admin.state.search','admin.stateEdit*','admin.cityList','admin.cityCreate', 'admin.city.search', 'admin.cityEdit*'],1)); ?>">

                            <li class="sidebar-item <?php echo e(menuActive(['admin.onBehalfList','admin.onBehalfCreate','admin.onBehalfEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.onBehalfList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.onBehalfList','admin.onBehalfCreate','admin.onBehalfEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('On Behalf'); ?></span>
                                </a>
                            </li>

                           

                            <li class="sidebar-item <?php echo e(menuActive(['admin.complexionList','admin.complexionCreate','admin.complexionEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.complexionList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.complexionList','admin.complexionCreate','admin.complexionEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Complexion'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-item <?php echo e(menuActive(['admin.bodyTypeList','admin.bodyTypeCreate','admin.bodyTypeEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.bodyTypeList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.bodyTypeList','admin.bodyTypeCreate','admin.bodyTypeEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Body Type'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-item <?php echo e(menuActive(['admin.maritalStatusList','admin.maritalStatusCreate','admin.maritalStatusEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.maritalStatusList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.maritalStatusList','admin.maritalStatusCreate','admin.maritalStatusEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Marital Status'); ?></span>
                                </a>
                            </li>

                           

                            <li class="sidebar-item <?php echo e(menuActive(['admin.familyValueList','admin.familyValueCreate','admin.familyValueEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.familyValueList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.familyValueList','admin.familyValueCreate','admin.familyValueEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Family Value'); ?></span>
                                </a>
                            </li>

 <!--                         
							<li class="sidebar-item <?php echo e(menuActive(['admin.hairColorList','admin.hairColorCreate','admin.hairColorEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.hairColorList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.hairColorList','admin.hairColorCreate','admin.hairColorEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Hair Color'); ?></span>
                                </a>
                            </li>
							
							 <li class="sidebar-item <?php echo e(menuActive(['admin.bodyArtList','admin.bodyArtCreate','admin.bodyArtEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.bodyArtList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.bodyArtList','admin.bodyArtCreate','admin.bodyArtEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Body Art'); ?></span>
                                </a>
                            </li>
	
							<li class="sidebar-item <?php echo e(menuActive(['admin.ethnicityList','admin.ethnicityCreate','admin.ethnicityEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.ethnicityList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.ethnicityList','admin.ethnicityCreate','admin.ethnicityEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Ethnicity'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-item <?php echo e(menuActive(['admin.personalValueList','admin.personalValueCreate','admin.personalValueEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.personalValueList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.personalValueList','admin.personalValueCreate','admin.personalValueEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Personal Value'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-item <?php echo e(menuActive(['admin.politicalViewList','admin.politicalViewCreate','admin.politicalViewEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.politicalViewList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.politicalViewList','admin.politicalViewCreate','admin.politicalViewEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Political View'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-item <?php echo e(menuActive(['admin.religiousServiceList','admin.religiousServiceCreate','admin.religiousServiceEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.religiousServiceList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.religiousServiceList','admin.religiousServiceCreate','admin.religiousServiceEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Religious Service'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-item <?php echo e(menuActive(['admin.affectionForList','admin.affectionForCreate','admin.affectionForEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.affectionForList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.affectionForList','admin.affectionForCreate','admin.affectionForEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Affection For'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-item <?php echo e(menuActive(['admin.humorList','admin.humorCreate','admin.humorEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.humorList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.humorList','admin.humorCreate','admin.humorEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Humor'); ?></span>
                                </a>
                            </li>
							

                            <li class="sidebar-item <?php echo e(menuActive(['admin.communityValueList','admin.communityValueCreate','admin.communityValueEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.communityValueList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.communityValueList','admin.communityValueCreate','admin.communityValueEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Community Value'); ?></span>
                                </a>
                            </li>
							
							 
							-->
							
							<li class="sidebar-item <?php echo e(menuActive(['admin.communityValueList','admin.communityValueCreate','admin.communityValueEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.communityValueList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.communityValueList','admin.communityValueCreate','admin.communityValueEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Intro Template'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-item <?php echo e(menuActive(['admin.religionList','admin.religionCreate','admin.religionEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.religionList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.religionList','admin.religionCreate','admin.religionEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Religion'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-item <?php echo e(menuActive(['admin.casteList','admin.casteCreate','admin.casteEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.casteList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.casteList','admin.casteCreate','admin.casteEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Caste'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-item <?php echo e(menuActive(['admin.subCasteList','admin.subCasteCreate','admin.subCasteEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.subCasteList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.subCasteList','admin.subCasteCreate','admin.subCasteEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Sub-Caste'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-item <?php echo e(menuActive(['admin.countryList','admin.countryCreate','admin.countryEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.countryList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.countryList','admin.countryCreate','admin.countryEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Country'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-item <?php echo e(menuActive(['admin.stateList','admin.stateCreate', 'admin.state.search','admin.stateEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.stateList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.stateList','admin.stateCreate', 'admin.state.search', 'admin.stateEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('State'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-item <?php echo e(menuActive(['admin.cityList','admin.cityCreate', 'admin.city.search', 'admin.city.search','admin.cityEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.cityList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.cityList','admin.cityCreate', 'admin.city.search', 'admin.cityEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('City'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo e(route('admin.email-send')); ?>"
                           aria-expanded="false">
                            <i class="fas fa-envelope-open text-info"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Send Email'); ?></span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo e(route('admin.whatsapp-send')); ?>"
                           aria-expanded="false">
                            <i class="fab fa-whatsapp text-success"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Send WhatsApp to Selected Users'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(adminAccessRoute(config('role.report_list.access.view'))): ?>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu"><?php echo app('translator')->get('Profile Reports'); ?></span></li>
                    <li class="sidebar-item <?php echo e(menuActive(['admin.reportList*'],3)); ?>">
                        <a class="sidebar-link" href="<?php echo e(route('admin.reportList')); ?>" aria-expanded="false">
                            <i class="fas fa-ban text-danger"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Reported Members'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(adminAccessRoute(config('role.story.access.view'))): ?>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu"><?php echo app('translator')->get('Manage Story'); ?></span></li>
                    <li class="sidebar-item <?php echo e(menuActive(['admin.storyList','admin.storyShow','admin.story.search'],3)); ?>">
                        <a class="sidebar-link" href="<?php echo e(route('admin.storyList')); ?>" aria-expanded="false">
                            <i class="fas fa-handshake text-orange"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Story List'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(adminAccessRoute(config('role.all_transaction.access.view'))): ?>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu"><?php echo app('translator')->get('All Transaction '); ?></span></li>

                    <li class="sidebar-item <?php echo e(menuActive(['admin.transaction*'],3)); ?>">
                        <a class="sidebar-link" href="<?php echo e(route('admin.transaction')); ?>" aria-expanded="false">
                            <i class="fas fa-exchange-alt text-purple"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Transaction'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(adminAccessRoute(config('role.payment_gateway.access.view'))): ?>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu"><?php echo app('translator')->get('Payment Settings'); ?></span></li>
                    <li class="sidebar-item <?php echo e(menuActive(['admin.payment.methods','admin.edit.payment.methods'],3)); ?>">
                        <a class="sidebar-link" href="<?php echo e(route('admin.payment.methods')); ?>"
                           aria-expanded="false">
                            <i class="fas fa-credit-card text-red"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Payment Methods'); ?></span>
                        </a>
                    </li>
                    <li class="sidebar-item <?php echo e(menuActive(['admin.deposit.manual.index','admin.deposit.manual.create','admin.deposit.manual.edit'],3)); ?>">
                        <a class="sidebar-link" href="<?php echo e(route('admin.deposit.manual.index')); ?>"
                           aria-expanded="false">
                            <i class="fa fa-university text-orange"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Manual Gateway'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(adminAccessRoute(config('role.payment_log.access.view'))): ?>
                    <li class="sidebar-item <?php echo e(menuActive(['admin.payment.pending'],3)); ?>">
                        <a class="sidebar-link" href="<?php echo e(route('admin.payment.pending')); ?>" aria-expanded="false">
                            <i class="fas fa-spinner text-primary"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Payment Request'); ?></span>
                        </a>
                    </li>

                    <li class="sidebar-item <?php echo e(menuActive(['admin.payment.log','admin.payment.search'],3)); ?>">
                        <a class="sidebar-link" href="<?php echo e(route('admin.payment.log')); ?>" aria-expanded="false">
                            <i class="fas fa-history text-warning"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Payment Log'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(adminAccessRoute(config('role.support_ticket.access.view'))): ?>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu"><?php echo app('translator')->get('Support Tickets'); ?></span></li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo e(route('admin.ticket')); ?>" aria-expanded="false">
                            <i class="fas fa-ticket-alt text-info"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('All Tickets'); ?></span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo e(route('admin.ticket',['open'])); ?>"
                           aria-expanded="false">
                            <i class="fas fa-spinner text-teal"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Open Ticket'); ?></span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo e(route('admin.ticket',['closed'])); ?>"
                           aria-expanded="false">
                            <i class="fas fa-times-circle text-danger"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Closed Ticket'); ?></span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo e(route('admin.ticket',['answered'])); ?>"
                           aria-expanded="false">
                            <i class="fas fa-reply text-green"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Answered Ticket'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(adminAccessRoute(config('role.subscriber.access.view'))): ?>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu"><?php echo app('translator')->get('Subscriber'); ?></span></li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo e(route('admin.subscriber.index')); ?>" aria-expanded="false">
                            <i class="fas fa-thumbs-up text-teal"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Subscriber List'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(adminAccessRoute(config('role.manage_staff.access.view'))): ?>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu"><?php echo app('translator')->get('Admin Accessibility'); ?></span></li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo e(route('admin.staff')); ?>" aria-expanded="false">
                            <i class="fa fa-users-cog text-indigo"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Role Permission'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(adminAccessRoute(array_merge(config('role.website_controls.access.view'), config('role.language_settings.access.view')))): ?>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu"><?php echo app('translator')->get('Controls'); ?></span></li>

                    <?php if(adminAccessRoute(config('role.website_controls.access.view'))): ?>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?php echo e(route('admin.basic-controls')); ?>" aria-expanded="false">
                                <i class="fas fa-cogs text-primary"></i>
                                <span class="hide-menu"><?php echo app('translator')->get('Basic Controls'); ?></span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-envelope text-success"></i>
                                <span class="hide-menu"><?php echo app('translator')->get('Email Settings'); ?></span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.email-controls')); ?>" class="sidebar-link">
                                        <span class="hide-menu"><?php echo app('translator')->get('Email Controls'); ?></span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.email-template.show')); ?>" class="sidebar-link">
                                        <span class="hide-menu"><?php echo app('translator')->get('Email Template'); ?> </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-mobile-alt text-danger"></i>
                                <span class="hide-menu"><?php echo app('translator')->get('SMS Settings'); ?></span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.sms.config')); ?>" class="sidebar-link">
                                        <span class="hide-menu"><?php echo app('translator')->get('SMS Controls'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.sms-template')); ?>" class="sidebar-link">
                                        <span class="hide-menu"><?php echo app('translator')->get('SMS Template'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-bell text-purple"></i>
                                <span class="hide-menu"><?php echo app('translator')->get('Push Notification'); ?></span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.notify-config')); ?>" class="sidebar-link">
                                        <span class="hide-menu"><?php echo app('translator')->get('Configuration'); ?></span>
                                    </a>
                                </li>

                                <li class="sidebar-item">
                                    <a href="<?php echo e(route('admin.notify-template.show')); ?>" class="sidebar-link">
                                        <span class="hide-menu"><?php echo app('translator')->get('Template'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item <?php echo e(menuActive(['admin.whatsapp.settings'],3)); ?>">
                            <a class="sidebar-link" href="<?php echo e(route('admin.whatsapp.settings')); ?>" aria-expanded="false">
                                <i class="fab fa-whatsapp text-success"></i>
                                <span class="hide-menu"><?php echo app('translator')->get('WhatsApp Settings'); ?></span>
                            </a>
                        </li>

                        <li class="sidebar-item <?php echo e(menuActive(['admin.plugin.config','admin.tawk.control','admin.fb.messenger.control','admin.google.recaptcha.control','admin.google.analytics.control'],3)); ?>">
                            <a class="sidebar-link" href="<?php echo e(route('admin.plugin.config')); ?>" aria-expanded="false">
                                <i class="fas fa-toolbox text-indigo"></i>
                                <span class="hide-menu"><?php echo app('translator')->get('Plugin Configuration'); ?></span>
                            </a>
                        </li>


                    <?php endif; ?>
                    <?php if(adminAccessRoute(config('role.language_settings.access.view'))): ?>
                        <li class="sidebar-item <?php echo e(menuActive(['admin.language.create','admin.language.edit*','admin.language.keywordEdit*'],3)); ?>">
                            <a class="sidebar-link" href="<?php echo e(route('admin.language.index')); ?>"
                               aria-expanded="false">
                                <i class="fas fa-language text-teal"></i>
                                <span class="hide-menu"><?php echo app('translator')->get('Manage Language'); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if(adminAccessRoute(config('role.theme_settings.access.view'))): ?>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu"><?php echo app('translator')->get('Theme Settings'); ?></span></li>


                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo e(route('admin.logo-seo')); ?>" aria-expanded="false">
                            <i class="fas fa-image text-info"></i><span
                                class="hide-menu"><?php echo app('translator')->get('Manage Logo & SEO'); ?></span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo e(route('admin.breadcrumb')); ?>" aria-expanded="false">
                            <i class="fas fa-file-image text-indigo"></i><span
                                class="hide-menu"><?php echo app('translator')->get('Manage Breadcrumb'); ?></span>
                        </a>
                    </li>

                    <li class="sidebar-item <?php echo e(menuActive(['admin.blogCategory','admin.blogCategoryCreate','admin.blogCategoryEdit*','admin.blogList','admin.blogCreate','admin.blogEdit*'],3)); ?>">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-book-reader text-gray-dark"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Manage Blog'); ?></span>
                        </a>
                        <ul aria-expanded="false"
                            class="collapse first-level base-level-line <?php echo e(menuActive(['admin.blogCategory','admin.blogCategoryCreate','admin.blogCategoryEdit*','admin.blogList','admin.blogCreate','admin.blogEdit*'],1)); ?>">

                            <li class="sidebar-item <?php echo e(menuActive(['admin.blogCategory','admin.blogCategoryCreate','admin.blogCategoryEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.blogCategory')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.blogCategory','admin.blogCategoryCreate','admin.blogCategoryEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Blog Category'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-item <?php echo e(menuActive(['admin.blogList','admin.blogCreate','admin.blogEdit*'])); ?>">
                                <a href="<?php echo e(route('admin.blogList')); ?>"
                                   class="sidebar-link <?php echo e(menuActive(['admin.blogList','admin.blogCreate','admin.blogEdit*'])); ?>">
                                    <span class="hide-menu"><?php echo app('translator')->get('Blog List'); ?></span>
                                </a>
                            </li>

                        </ul>
                    </li>


                    <li class="sidebar-item <?php echo e(menuActive(['admin.template.show*'],3)); ?>">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-clipboard-list text-indigo"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Section Heading'); ?></span>
                        </a>
                        <ul aria-expanded="false"
                            class="collapse first-level base-level-line <?php echo e(menuActive(['admin.template.show*'],1)); ?>">

                            <?php $__currentLoopData = array_diff(array_keys(config('templates')),['message','template_media']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="sidebar-item <?php echo e(menuActive(['admin.template.show'.$name])); ?>">
                                    <a class="sidebar-link <?php echo e(menuActive(['admin.template.show'.$name])); ?>"
                                       href="<?php echo e(route('admin.template.show',$name)); ?>">
                                        <span class="hide-menu"><?php echo app('translator')->get(ucfirst(kebab2Title($name))); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>
                    </li>


                    <?php
                        $segments = request()->segments();
                        $last  = end($segments);
                    ?>
                    <li class="sidebar-item <?php echo e(menuActive(['admin.content.create','admin.content.show*'],3)); ?>">
                        <a class="sidebar-link has-arrow <?php echo e(Request::routeIs('admin.content.show',$last) ? 'active' : ''); ?>"
                           href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-clipboard-list text-teal"></i>
                            <span class="hide-menu"><?php echo app('translator')->get('Content Settings'); ?></span>
                        </a>
                        <ul aria-expanded="false"
                            class="collapse first-level base-level-line <?php echo e(menuActive(['admin.content.create','admin.content.show*'],1)); ?>">
                            <?php $__currentLoopData = array_diff(array_keys(config('contents')),['message','content_media']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="sidebar-item <?php echo e(($last == $name) ? 'active' : ''); ?> ">
                                    <a class="sidebar-link <?php echo e(($last == $name) ? 'active' : ''); ?>"
                                       href="<?php echo e(route('admin.content.index',$name)); ?>">
                                        <span class="hide-menu"><?php echo app('translator')->get(ucfirst(kebab2Title($name))); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="list-divider"></li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>