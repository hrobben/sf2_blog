sf2_blog
========

A Symfony project created on June 25, 2015, 8:25 am.

This project is developed for digieet.eu.

After login (ROLE_ADMIN): 

- possible to change About-text

- extra menu "Settings" visible

- via "Settings" editing parameters.yml

        API_UserName: paypal_api.login_username
        API_Password: UAKSJDKSDJ_API_PAYPALL-password
        API_Signature: AAVrjpoAQiFyxAG1.GKTnu6QvmGhwquIQh5UwTfBP;akdfj;sakfsaf
        nvpStr: &RETURNALLCURRENCIES=1 // 1 = to get all amount for all currencies 0=only master currency
        Show_PayPal: YES
        
- paypal will only be visible if Show_PayPal: YES or ROLE_ADMIN


