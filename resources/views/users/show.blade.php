@extends('layouts.app')

@section('content')
    <div class="profile-banner mdl-color--blue-grey-300"></div>
    <div class="profile-info">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--4-col-desktop mdl-card mdl-cell--12-col-tablet mdl-shadow--2dp mdl-typography--text-center">
                <div class="profile-image">
                    <div>
                        <img src="http://static1.squarespace.com/static/50de3e1fe4b0a05702aa9cda/t/50eb2245e4b0404f3771bbcb/1357589992287/ss_profile.jpg" alt="">
                        <a class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
                            <i class="material-icons">email</i>
                        </a>
                    </div>
                </div>
                <div class="profile-name">
                    <h4>Sandro Ferror</h4>
                </div>
                <div class="profile-stats">
                    <div class="profile-stat-item">
                        <div class="profile-stat-value">A+</div>
                        <div class="profile-stat-name">rating</div>
                    </div>
                    <div class="profile-stat-item">
                        <div class="profile-stat-value">44</div>
                        <div class="profile-stat-name">posts</div>
                    </div>

                    <div class="profile-stat-item">
                        <div class="profile-stat-value">1</div>
                        <div class="profile-stat-name">trips</div>
                    </div>
                </div>
                <div class="mdl-card__menu">
                    <button id="profile-more-button"
                            class="mdl-button mdl-js-button mdl-button--icon">
                        <i class="material-icons">more_vert</i>
                    </button>
                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                        for="profile-more-button">
                        <li class="mdl-menu__item">Some Action</li>
                        <li class="mdl-menu__item">Another Action</li>
                        <li disabled class="mdl-menu__item">Disabled Action</li>
                        <li class="mdl-menu__item">Yet Another Action</li>
                    </ul>
                </div>
            </div>
            <div class="mdl-cell mdl-cell--8-col-desktop mdl-card mdl-shadow--2dp mdl-cell--12-col-tablet">
                <div class="mdl-card__title" style="background-color: #3f51b5; color: #fff">
                    <h2 class="mdl-card__title-text">Information</h2>
                </div>
                <ul class="mdl-list profile-data">
                    <li class="mdl-list__item">
                        <span class="mdl-list__item-primary-content" id="tt_status">
                            <i class="material-icons mdl-list__item-icon">check_circle</i>
                            Active
                        </span>
                        <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="tt_status">
                            Status
                        </div>
                    </li>
                    <li class="mdl-list__item">
                        <span class="mdl-list__item-primary-content" id="tt_external_email">
                            <i class="material-icons mdl-list__item-icon">question_answer</i>
                            example@example.com
                        </span>
                        <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="tt_external_email">
                            Email
                        </div>
                    </li>
                    <li class="mdl-list__item">
                        <span class="mdl-list__item-primary-content" id="tt_address">
                            <i class="material-icons mdl-list__item-icon">location_city</i>
                            7141 Rue Sherbrooke O, Montréal, QC H4B 1R6
                        </span>
                        <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="tt_address">
                            Address
                        </div>
                    </li>
                    <li class="mdl-list__item">
                        <span class="mdl-list__item-primary-content" id="tt_birthday">
                            <i class="material-icons mdl-list__item-icon">cake</i>
                            August 19, 1995
                        </span>
                        <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="tt_birthday">
                            Birthday
                        </div>
                    </li>
                    <li class="mdl-list__item">
                        <span class="mdl-list__item-primary-content" id="tt_licence">
                            <i class="material-icons mdl-list__item-icon">card_membership</i>
                            KOGP 1324 1490
                        </span>
                        <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="tt_licence">
                            License
                        </div>
                    </li>
                    <li class="mdl-list__item">
                        <span class="mdl-list__item-primary-content" id="tt_policies">
                            <i class="material-icons mdl-list__item-icon">warning</i>
                            <span class="mdl-chip">
                                <span class="mdl-chip__text">No eating in my car.</span>
                            </span>
                        </span>
                        <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="tt_policies">
                            Policies
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="profile-posts">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-card mdl-cell--12-col mdl-shadow--3dp" style="min-height: auto;">
                <div class="mdl-card__title" style="background-color: #3f51b5; color: #fff">
                    <h2 class="mdl-card__title-text">Trips and Services</h2>
                </div>
                <ul class="filter">
                    <li>
                        <button type="button" class="mdl-chip filter-chip active">
                            <span class="mdl-chip__text">All</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="mdl-chip filter-chip">
                            <span class="mdl-chip__text">Long</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="mdl-chip filter-chip">
                            <span class="mdl-chip__text">Local</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="mdl-chip filter-chip">
                            <span class="mdl-chip__text">Services</span>
                        </button>
                    </li>
                </ul>
                <div class="post-listing">
                    <div class="post">
                        <div class="post-price">
                            $12.30
                        </div>
                        <div class="post-title">
                            MONTREAL TO TORONTO
                        </div>
                        <div class="post-info">
                            <div class="post-description">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Mauris sagittis pellentesque lacus eleifend lacinia...
                            </div>
                            <div class="post-stats">
                            <span>
                                <i class="material-icons">date_range</i>
                                21/10/2016
                            </span>
                                <span>
                                <i class="material-icons">forum</i>
                                11
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="post">
                        <div class="post-price">
                            $12.30
                        </div>
                        <div class="post-title">
                            MONTREAL TO TORONTO
                        </div>
                        <div class="post-info">
                            <div class="post-description">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Mauris sagittis pellentesque lacus eleifend lacinia...
                            </div>
                            <div class="post-stats">
                            <span>
                                <i class="material-icons">date_range</i>
                                21/10/2016
                            </span>
                                <span>
                                <i class="material-icons">forum</i>
                                11
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="post">
                        <div class="post-price">
                            $12.30
                        </div>
                        <div class="post-title">
                            MONTREAL TO TORONTO
                        </div>
                        <div class="post-info">
                            <div class="post-description">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Mauris sagittis pellentesque lacus eleifend lacinia...
                            </div>
                            <div class="post-stats">
                            <span>
                                <i class="material-icons">date_range</i>
                                21/10/2016
                            </span>
                                <span>
                                <i class="material-icons">forum</i>
                                11
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="post">
                        <div class="post-price">
                            $12.30
                        </div>
                        <div class="post-title">
                            MONTREAL TO TORONTO
                        </div>
                        <div class="post-info">
                            <div class="post-description">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Mauris sagittis pellentesque lacus eleifend lacinia...
                            </div>
                            <div class="post-stats">
                            <span>
                                <i class="material-icons">date_range</i>
                                21/10/2016
                            </span>
                                <span>
                                <i class="material-icons">forum</i>
                                11
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection