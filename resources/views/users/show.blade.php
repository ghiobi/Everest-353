@extends('layouts.app')

@section('content')
    <div class="profile-banner mdl-color--blue-grey-300"></div>
    <div class="profile-info">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--4-col-desktop mdl-card mdl-cell--12-col-tablet mdl-shadow--3dp mdl-typography--text-center">
                <div class="profile-image">
                    <img src="http://static1.squarespace.com/static/50de3e1fe4b0a05702aa9cda/t/50eb2245e4b0404f3771bbcb/1357589992287/ss_profile.jpg" alt="">
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
                    <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                        <i class="material-icons">more_vert</i>
                    </button>
                </div>
            </div>
            <div class="mdl-cell mdl-cell--8-col-desktop mdl-card mdl-shadow--3dp mdl-cell--12-col-tablet">
                <div class="mdl-card__title mdl-color--blue-grey-100">
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
@endsection