@if(Session::has('success'))
    <div class="demo-card-wide mdl-card mdl-shadow--2dp notification">
        <div class="mdl-card__supporting-text">
            <div class="mdl-color-text--green-700">
                <i class="material-icons">check_circle</i>
                <strong class="notification-title">Success!</strong>
            </div>
            <div class="notification-text">{{ Session::get('success') }}</div>
        </div>
    </div>
@endif