<div class="mdl-textfield mdl-js-textfield{{ ($errors->has($name))? ' is-invalid' : '' }} mdl-textfield--floating-label fwidth">
    <textarea class="mdl-textfield__input " id="form__{{ $name }}" name="{{ $name }}">{{ (isset($value))? $value : old($name) }}</textarea>
    <label class="mdl-textfield__label " for="form__{{ $name }}" >{{ $label }}</label>
    @if($errors->has($name))
        <span class="mdl-textfield__error">{{ $errors->first($name) }}</span>
    @endif
</div>