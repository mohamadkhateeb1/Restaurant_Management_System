<div class="card-body">
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif


  <x-form.input
      type="text"
      name="name"
      placeholder="Enter Name"
      label="Name"
      :value="old('name', $admin->name)"
  />


  @php
    $defaultEmail = old('email', $admin->exists ? $admin->email : 'admin@gmail.com');
  @endphp
  <x-form.input
      type="email"
      name="email"
      placeholder="Enter Email"
      label="Email"
      :value="$defaultEmail"
  />


  @php
    $defaultPassword = old('password', $admin->exists ? '' : '123456789');
  @endphp
  <x-form.input
      type="password"
      name="password"
      placeholder="{{ $admin->exists ? 'Leave blank to keep current password' : 'Enter Password' }}"
      label="Password"
      :value="$defaultPassword"
  />


  @php
    $selectedRoles = old('roles', $admin_roles ?? []);
  @endphp
  <div class="form-group mt-3">
    <label class="d-block mb-2">Roles</label>
    <div class="border rounded p-2" style="max-height:220px;overflow:auto;">
      @foreach ($roles as $role)
        <div class="form-check">
          <input
            class="form-check-input"
            type="checkbox"
            id="role_{{ $role->id }}"
            name="roles[]"
            value="{{ $role->id }}"
            @checked(in_array($role->id, $selectedRoles))
          >
          <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
        </div>
      @endforeach
    </div>
    @error('roles')
      <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
  </div>

</div>
