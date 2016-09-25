<div class="mdl-textfield mdl-js-textfield{{ ($errors->has($name))? ' is-invalid' : '' }} mdl-textfield--floating-label full-width">
    <input type="text" class="mdl-textfield__input " id="form__{{ $name }}" name="{{ $name }}">
    <label class="mdl-textfield__label " for="form__{{ $name }}" >{{ $label }}</label>
    @if($errors->has($name))
        <span class="mdl-textfield__error">{{ $errors->first($name) }}</span>
    @endif
</div>