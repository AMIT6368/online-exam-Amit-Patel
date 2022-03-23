          
        var base_url = BASE_URL;
        var fb_app_id = $('#fb_app_id').val();
        fb_app_id = fb_app_id ? fb_app_id : '';
        
        var fb__permissions = $('#fb__permissions').val();
        fb__permissions = fb__permissions ? fb__permissions : [];
              /*
             * Initiate Facebook JS SDK
             */

            window.fbAsyncInit = function () {
                FB.init({
                    appId: fb_app_id, // Your app id
                    cookie: true, // enable cookies to allow the server to access the session
                    xfbml: false, // disable xfbml improves the page load time
                    version: 'v2.5', // use version 2.4
                    status: true // Check for user login status right away
                });
                FB.getLoginStatus(function (response) {
                    //console.log('getLoginStatus', response);
                    loginCheck(response);
                });
            };

            $(function () {
                /*
                 * Trigger login
                 */
                $('#login').on('click', function () {
                    FB.login(function () {
                        loginCheck();
                    }, {scope: fb__permissions});
                });

                /*
                 * 
                 */
                $('#logout').on('click', function () {
                    $.ajax({
                        type: "POST",
                        url: base_url + "auth/logout_js",
                        dataType: 'JSON',
                        success: function (response) {
                            logout();
                            console.log('FB logout');
                        },
                        error: function () {
                            lobibox('error', 'Failed request to delete');
                            console.log('cant logout from the server');
                        }
                    }); 
                });
            });

            function logout() {
                FB.logout(function (response) {
                    // Person is now logged out
                    loginCheck();
                });
            }
            /*
             * Get login status
             */
            function loginCheck() {
                FB.getLoginStatus(function (response) {
                    //console.log('loginCheck', response);
                    statusCheck(response);
                });
            }

            /*
             * Check login status
             */
            function statusCheck(response) {
                console.log('statusCheck', response.status);
                if (response.status === 'connected') {
                    user = getUser();
                    console.log(user);
                    // alert(user.name);
                    // $('.login').hide();
                    // $('.logout').show();
                    // $('.form').fadeIn();

                } else if (response.status === 'not_authorized') {
                    // User logged into facebook, but not to our app.
                    $('#is_login').hide();
                    $('#is_logout').show();
                    $('#user').html('');
                } else {
                    // User not logged into Facebook.
                    $('#is_login').hide();
                    $('#is_logout').show();
                    $('#user').html('');
                }
            }

            /*
             * Here we run a very simple test of the Graph API after login is
             * successful.  See statusChangeCallback() for when this call is made.
             */
            function getUser() 
            {
                FB.api("/me", {fields: "id,name,email,picture"}, function(response){
                                $.ajax({
                                  type: "POST",
                                  url: BASE_URL + "user/check_fb_login",
                                  data: {
                                    user_id: response.id,
                                    user_name: response.name,
                                    user_email: response.email,
                                    user_picture: "http://graph.facebook.com/" + response.id + "/picture?type=small",
                                    user_response : response,
                                  },

                                  success: function (response) {
                                    if (response) {
                                      response = JSON.parse(response);
                                      if (response.status != "error") 
                                      {
                                        logout();
                                        location.reload();
                                      } 
                                      else 
                                      {
                                        swal(response.msg, "error");
                                        location.reload();
                                      }
                                    } else {
                                      swal("Server Response Error", "error");
                                    }
                                  },
                                  error: function (e) {
                                    console.log(e);
                                  },
                                });
                      });

                  
            }

            /*
             * Load the SDK asynchronously
             */
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));