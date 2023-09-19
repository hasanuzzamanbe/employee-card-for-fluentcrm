<?php
$employee = emcDb()->table('employee_card_info')->where('hash',get_query_var('person'))->first();

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="<?= EMPLOYEE_CARD_URL . 'assets/css/front-end.css' ?>" rel="stylesheet">

    <?php if (!is_null($employee)): ?>
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css"
              integrity="sha512-vebUliqxrVkBy3gucMhClmyQP9On/HAWQdKDXRaAlb/FKuTbxkjPKUyqVOxAcGwFDka79eTF+YXwfke1h3/wfg=="
              crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <title>Contact <?= $employee->name ?></title>
    <?php else: ?>
        <title>Contact Card</title>
    <?php endif; ?>


</head>
<body class="bg-black m-0">
<?php if (!is_null($employee)): ?>
    <?php
    $socialInfo = json_decode($employee->social_info);
    $iconClasses = [
        'phone' => 'las la-mobile-alt',
        'email' => 'las la-at',
        'address' => 'las la-map-marked-alt',
        'facebook' => 'lab la-facebook-f',
        'instagram' => 'lab la-instagram',
        'twitter' => 'lab la-twitter',
        'linkedin' => 'lab la-linkedin-in',
        'github' => 'lab la-github',
        'figma' => 'lab la-figma',
        'wordpress' => 'lab la-wordpress',
        'wp' => 'lab la-wordpress',
        'dribble' => 'lab la-dribbble',
        'website' => 'las la-globe',
        'web' => 'las la-globe',
        'portfolio' => 'las la-globe',
    ];
    ?>
    <div class="flex justify-center ">
        <div class="max-w-[400px] shadow-lg relative h-screen employee-card-wrapper">
            <div class="pb-[50px]">
                <div class="w-full relative">
                    <img id="employee_profile_image" class="w-full object-fill" src="<?= $employee->image ?>"/>
                    <div class="absolute bottom-0 w-full bg-gradient-to-t from-black min-h-24 p-4">
                        <h1 class="text-center text-white m-2" id="employee_name"><?= $employee->name ?></h1>
                        <p id="employee_designation"
                           class="text-center text-white m-0"><?= $employee->designation ?></p>
                        <div class="flex gap-4 mt-2">
                            <div class="w-10 h-10 rounded-full bg-gray-400 flex justify-center items-center cursor-pointer">
                                <a href=tel:<?= $employee->phone; ?>">
                                    <svg class="w-4 h-4 fill-white" focusable="false" viewBox="0 0 20 20"
                                         aria-hidden="true"
                                         style="font-size: 10px;">
                                        <path d="M9.105 7.38l-2.829 2.829c-1.040 1.040-2.729 1.040-3.771 0l-0.943-0.943c-2.083-2.084-2.083-5.46 0-7.544l0.943-0.943c1.041-1.040 2.731-1.040 3.771 0l2.829 2.829c1.041 1.041 1.041 2.729 0 3.771z"></path>
                                        <path d="M18.695 16.97l-0.943 0.943c-2.084 2.084-5.46 2.084-7.543 0l-0.943-0.943c-1.041-1.041-1.041-2.729 0-3.771l2.828-2.829c1.041-1.040 2.731-1.040 3.771 0l2.829 2.829c1.041 1.041 1.041 2.729 0 3.771z"></path>
                                        <path d="M13.026 17.763v0c-0.82 0.819-2.148 0.819-2.967 0l-8.347-8.347c-0.82-0.82-0.82-2.148 0-2.967 0.819-0.82 2.147-0.82 2.965 0l8.348 8.347c0.819 0.82 0.819 2.148 0 2.967z">
                                        </path>
                                    </svg>
                                </a>
                            </div>

                            <div class="w-10 h-10 rounded-full bg-gray-400 flex justify-center items-center cursor-pointer">
                                <a href="mailto:<?= $employee->email; ?>">
                                    <svg class="w-4 h-4 fill-white" focusable="false" viewBox="0 0 16 13"
                                         aria-hidden="true">
                                        <path d="M14 13H2C0.896 13 0 12.104 0 11V3C0 1.896 0.896 1 2 1H14C15.104 1 16 1.896 16 3V11C16 12.104 15.104 13 14 13Z"
                                              fill-rule="evenodd" clip-rule="evenodd" fill="white"></path>
                                        <path d="M1 1L6.586 6.431C7.367 7.19 8.633 7.19 9.414 6.431L15 1"
                                              class="stroke-gray-400"
                                              stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M2 11L5 8" class="stroke-gray-400" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
                                        <path d="M14 11L11 8" class="stroke-gray-400" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
                                    </svg>
                                </a>
                            </div>

                            <div class="w-10 h-10 rounded-full bg-gray-400 flex justify-center items-center cursor-pointer">
                                <svg class="w-4 h-4 fill-white" focusable="false" viewBox="0 0 14 16"
                                     aria-hidden="true">
                                    <path d="M13 7C13 10.313 10.313 13 7 13C3.687 13 1 10.313 1 7C1 3.687 3.687 1 7 1C10.313 1 13 3.687 13 7Z"
                                          fill-rule="evenodd" clip-rule="evenodd"></path>
                                    <path class="stroke-white"
                                          d="M13 7C13 10.313 10.313 13 7 13C3.687 13 1 10.313 1 7C1 3.687 3.687 1 7 1C10.313 1 13 3.687 13 7Z"
                                          fill-rule="evenodd" clip-rule="evenodd" stroke-width="2"></path>
                                    <path d="M7 16.0001C7 16.0001 14 12.8281 14 7.27706C14 1.72606 7 8.07006 7 8.07006V16.0001Z"
                                          fill-rule="evenodd" clip-rule="evenodd"></path>
                                    <path d="M7 16.0001C7 16.0001 0 12.8281 0 7.27706C0 1.72606 7 8.07006 7 8.07006V16.0001Z"
                                          fill-rule="evenodd" clip-rule="evenodd"></path>
                                    <path d="M10.5 7C10.5 8.933 8.933 10.5 7 10.5C5.067 10.5 3.5 8.933 3.5 7C3.5 5.067 5.067 3.5 7 3.5C8.933 3.5 10.5 5.067 10.5 7Z"
                                          fill-rule="evenodd" clip-rule="evenodd" stroke="currentColor"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($employee->description): ?>
                    <div class="mt-4 px-4">
                        <div class="rounded-lg shadow bg-white p-8">
                            <?= $employee->description ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($employee->phone)): ?>
                    <div class="mt-2 px-4 py-2">
                        <div class="rounded-lg shadow bg-white p-8 grid grid-cols-7">
                            <div class="col-span-1">
                                <i class="<?= $iconClasses['phone'] ?>"></i>
                            </div>
                            <div id="employee_phone" class="col-span-6">
                                <a href=tel:<?php echo $employee->phone; ?>">
                                    <?= $employee->phone ?>
                                </a>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

                <?php if (!empty($employee->email)): ?>
                    <div class="mt-2 px-4 py-2">
                        <div class="rounded-lg shadow bg-white p-8 grid grid-cols-7">
                            <div class="col-span-1">
                                <i class="<?= $iconClasses['email'] ?>"></i>
                            </div>
                            <div id="employee_email" class="col-span-6">
                                <a href="mailto:<?= $employee->email; ?>">
                                    <?= $employee->email ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mt-2 px-4 py-2">
                    <div class="rounded-lg shadow bg-white p-8 grid grid-cols-7">
                        <div class="col-span-1">
                            <i class="<?= $iconClasses['address'] ?>"></i>
                        </div>
                        <div class="col-span-6">
                            <table>
                                <tbody>
                                <tr>
                                    <td>Address:</td>
                                    <td><?= $employee->address_1 ?></td>
                                </tr>

                                <tr>
                                    <td>City:</td>
                                    <td><?= $employee->city ?></td>
                                </tr>

                                <tr>
                                    <td>State:</td>
                                    <td><?= $employee->state ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-2 px-4 py-2">
                    <div class="rounded-lg shadow bg-white p-8 ">
                        <h3>Social Info</h3>
                        <?php foreach ($socialInfo as $name => $info):
                            if (!empty($info)):
                                ?>
                                <div class="grid grid-cols-7">
                                    <div class="col-span-1 flex items-center">
                                        <div class="w-8 h-8 flex justify-center items-center">
                                            <?php if (isset($iconClasses[$name])): ?>
                                                <i class="<?= $iconClasses[$name] ?>"></i>
                                            <?php else: ?>
                                                <span class="uppercase flex justify-center items-center w-full h-full rounded-full border-2"><?= substr($name, 0, 1) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-span-6">
                                        <p class="my-2"><a href="<?= $info ?>"><?= $name ?>  </a></p>
                                    </div>
                                </div>

                            <?php endif;
                        endforeach;
                        ?>

                    </div>
                </div>
            </div>

            <div class="px-4 fixed bottom-0 w-[400px]">
                <div class=" text-center bg-black rounded-tr rounded-tl">
                    <button id="employee_vcard_download" class="rounded bg-blue-500 w-full text-white px-4 py-2">Add
                        Contact
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="bg-white w-full min-h-screen flex flex-col justify-center items-center">
        <div class="max-w-[600px]">
            <img src="<?= EMPLOYEE_CARD_URL.'assets/images/404.jpg' ?>" alt="Contact Not Found"/>
        </div>
        <h2 class="text-3xl text-bold">Sorry!! Contact not found.</h2>
    </div>
<?php endif; ?>

<?php if (!is_null($employee)): ?>
    <script src="<?= EMPLOYEE_CARD_URL . 'assets/admin/js/front-end.js' ?>"></script>
<?php endif; ?>
</body>
</html>
