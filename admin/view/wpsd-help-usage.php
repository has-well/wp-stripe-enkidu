<div class="wpsd-wrap" style="padding-top:20px;">
    <div class="wpsd_personal_wrap wpsd_personal_help" style="width: 75%; float: left; margin-top: 5px; text-align: center;">
        <h1>WordPress Stripe Donation Video Tutorial</h1>
        <div class="help-link">
            <iframe width="800px" height="450px" src="https://www.youtube.com/embed/IGjaOmKJ4L4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div style="width: 800px; margin:0 auto; text-align:left;">
            <h2>* How can I Display the Donation Form?</h2>
            <p style="text-align: left;">
                Firstly, Go to “Key Settings” and add your stripe keys which you will get from your stripe account (See attached video).
                <br>
                Secondly, Create a page and name it as you wish like “Donation”
                <br>
                Finally, Put the shortcode [wp_stripe_donation] in that page and Update it.
                <br>
                You will see your donation form on that page.
            </p>
            <h2>* How can I Display Multiple Amounts?</h2>
            <p style="text-align: left;">
                Go to “General Settings” and you will see an option “Amounts” there.<br>
                Put your amounts like “5,10,50,100,500,100” and you will see them in the form.
            </p>
            <h2>* How can I Change the Currency?</h2>
            <p style="text-align: left;">
                Go to “General Settings” and you will see an option “Currency” there.<br>
                Select your Currency from the drop down and save it.<br>
                You will see it immediately in the amount section in the donation form.
            </p>
            <h2>* How to display multiple donation items?</h2>
            <p style="text-align: left;">
                Go to “General Settings” and you will see an option “Donation For Options” there.<br>
                Put your items like “Item One,Item Two,Item Three” and you will see them in the form drop down section.
            </p>
        </div>
    </div>
    
    <?php $this->wpsd_admin_sidebar(); ?>   
</div>