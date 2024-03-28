@extends('layouts.myapp')
@section('content')
    <div class="grid place-items-center " >
        <div class="border p-5 md:w-1/2 w-4/5 bg-sec-100 my-12">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name : </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 ">
                    @error('name')
                        <span>
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Address
                        : </label>
                    <input type="email" id="email" name="email" value="{{ old('name') }}"
                        class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 ">
                    @error('email')
                        <span>
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role :</label>
                    <select id="role" name="role"
                        class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 ">
                        <option value="user">User</option>
                        <option value="owner">Owner</option>
                        <option value="driver">Driver</option>
                    </select>
                </div>

               

                <div class="mb-6" id="insuranceNumberField" style="display: none;">
    <label for="insurance_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Insurance Number :</label>
    <input type="text" name="insurance_number" id="insurance_number" class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 ">
</div>

<div class="mb-6" id="add1" style="display: none;">
    <label for="address1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address 1 :</label>
    <input type="text" name="address1" id="address1" class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 ">
</div>

<div class="mb-6" id="add2" style="display: none;">
    <label for="address2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address 2 :</label>
    <input type="text" name="address2" id="address2" class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 ">
</div>

<div class="mb-6" id="ci" style="display: none;">
    <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City :</label>
    <input type="text" name="city" id="city" class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 ">
</div>

<div class="mb-6" id="pin" style="display: none;">
    <label for="pincode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pincode :</label>
    <input type="text" name="pincode" id="pincode" class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 ">
</div>

<div class="mb-6"  id="mob_no" style="display: none;">
    <label for="mobile_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mobile No :</label>
    <input type="text" name="mobile_no" id="mobile_no" class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 ">
</div>

<div class="mb-6"  id="al_no" style="display: none;">
    <label for="alternate_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alternate No :</label>
    <input type="text" name="alternate_no" id="alternate_no" class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 ">
</div>

<div class="mb-6"  id="ag" style="display: none;">
    <label for="age" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Age :</label>
    <input type="text" name="age" id="age" class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 ">
</div>

<div class="mb-6" id="gen">
    <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender :</label>
    <select name="gender" id="gender" class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5">
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
    </select>
</div>


<!-- <div class="mb-6"   id="sta" style="display: none;">
    <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status :</label>
    <input type="text" name="status" id="status" class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 ">
</div> -->

                <!-- Input field for license number -->
                <div class="mb-6" id="licenseNumberField" style="display: none;">
                    <label for="license_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">License Number :</label>
                    <input type="text" id="license_number" name="license_number" class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 ">
                </div>



                <div class="flex md:flex-row flex-col justify-evenly px-6 py-4 items-center text-center">

                    <div class="grid grid-cols-3 ">
                        <div class="m-3">
                            <input type="radio" name="avatar_option" value="/images/avatars/avatar_1.jpg" id="avatar_1" class="hidden" >
                            <label class="" for="avatar_1">
                                <img loading="lazy" class=" avatar w-12 " src="/images/avatars/avatar_1.jpg" alt="">
                            </label>
                        </div>
                        <div class="m-3">
                            <input type="radio" name="avatar_option" value="/images/avatars/avatar_2.jpg" id="avatar_2" class="hidden">
                            <label class="" for="avatar_2">
                                <img loading="lazy" class=" avatar w-12" src="/images/avatars/avatar_2.jpg" alt="">
                            </label>
                        </div>
                        <div class="m-3">
                            <input type="radio" name="avatar_option" value="/images/avatars/avatar_3.jpg" id="avatar_3" class="hidden">
                            <label class="" for="avatar_3">
                                <img loading="lazy" class=" avatar w-12" src="/images/avatars/avatar_3.jpg" alt="">
                            </label>
                        </div>
                        <div class="m-3">
                            <input type="radio" name="avatar_option" value="/images/avatars/avatar_4.jpg" id="avatar_4" class="hidden">
                            <label class="" for="avatar_4">
                                <img loading="lazy" class=" avatar w-12" src="/images/avatars/avatar_4.jpg" alt="">
                            </label>
                        </div>
                        <div class="m-3">
                            <input type="radio" name="avatar_option" value="/images/avatars/avatar_5.jpg" id="avatar_5" class="hidden">
                            <label class="" for="avatar_5">
                                <img loading="lazy" class=" avatar w-12" src="/images/avatars/avatar_5.jpg" alt="">
                            </label>
                        </div>
                        <div class="m-3">
                            <input type="radio" name="avatar_option" value="/images/avatars/avatar_6.jpg"  id="avatar_6" class="hidden">
                            <label class="" for="avatar_6">
                                <img loading="lazy" class=" avatar w-12" src="/images/avatars/avatar_6.jpg" alt="">
                            </label>
                        </div>
                    </div>

                    <div class="w-1/3 mb-2">
                        <p>OR</p>
                    </div>

                    <div>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none "
                            id="file_input" type="file" name="avatar_choose">
                    </div>

                </div>

                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        password :</label>
                    <input type="password" id="password"
                        class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 "
                        name="password">
                    @error('password')
                        <span>
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password-confirm" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Confirm password :</label>
                    <input type="password" id="password-confirm"
                        class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5 "
                        name="password_confirmation">

                </div>


                <div class="flex items-start mb-6">
                    <div class="flex items-center h-5">
                        <input id="remember" type="checkbox" value=""
                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-pr-300 "
                            name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    </div>
                    <label for="remember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember
                        me</label>
                </div>
                <button type="submit"
                    class="text-white bg-pr-400 hover:bg-pr-600 focus:ring-4 focus:outline-none focus:ring-pr-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-pr-600 dark:hover:bg-pr-700 dark:focus:ring-pr-800">Register</button>


            </form>
        </div>

    </div>
    <script>
        var radios = document.querySelectorAll('input[type="radio"]');
        var images = document.querySelectorAll('.avatar');

        radios.forEach(function(radio, index) {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    images.forEach(function(image, imageIndex) {
                        if (imageIndex === index) {
                            image.classList.add('border', 'border-red-600', 'rounded-full', 'p-1');
                        } else {
                            image.classList.remove('border', 'border-red-600', 'rounded-full',
                                'p-1');
                        }
                    });
                }
            });
        });
  


document.addEventListener("DOMContentLoaded", function() {
    const roleSelect = document.getElementById("role");
    const insuranceNumberField = document.getElementById("insuranceNumberField");
    const licenseNumberField = document.getElementById("licenseNumberField");

    roleSelect.addEventListener("change", function() {
        const selectedRole = roleSelect.value;

        // Hide all input fields initially
        insuranceNumberField.style.display = "none";
        licenseNumberField.style.display = "none";

        // Show the corresponding input field based on the selected role
        if (selectedRole === "owner") {
            insuranceNumberField.style.display = "block";
            add1.style.display="block";
            add2.style.display="block";
            ci.style.display="block";
            pin.style.display="block";
            mob_no.style.display="block";
         
            ag.style.display="block";
            gen.style.display="block";
            sta.style.display="block";

        } else if (selectedRole === "driver") {
            licenseNumberField.style.display = "block";
            
            add1.style.display="block";
            add2.style.display="block";
            ci.style.display="block";
            pin.style.display="block";
            mob_no.style.display="block";
            al_no.style.display="block";
            ag.style.display="block";
            gen.style.display="block";
            sta.style.display="block";
        }else if (selectedRole === "driver") {
            licenseNumberField.style.display = "block";
            
            add1.style.display="block";
            
            ci.style.display="block";
            pin.style.display="block";
            mob_no.style.display="block";
            al_no.style.display="block";
            ag.style.display="block";
            gen.style.display="block";
            sta.style.display="block";
        }
    });
});
</script>
@endsection