<section id="intro-text">
    <p>The <strong>Startup Manifesto Policy Tracker</strong> is an online tool for tracking 
        implementation of the 22 recommendations set out in the 
        Startup Manifesto, an innovative blueprint for a more entrepreneurial 
        Europe written by founders of world-leading technology companies based 
        in Europe.</p>

    <p>The Tracker translates the 22 specific recommendations in the Startup 
        Manifesto into concrete policies whose implementation – 
        or non-implementation – will be followed on national level in 
        coming years. It is a visual, web-based and open approach to 
        monitoring policy progress in key areas, and is intended to 
        enhance collaboration and accountability among countries and 
        the European Commission.</p>
    
    <p>The purpose of the Startup Manifesto Policy Tracker is:</p>
    <ul id="more"><li>to operationalise the strategic Startup Manifesto recommendations into a set of actionable policy initiatives;</li>
        <li>to provide a straightforward and easy-to-understand overview of the progress each country is making in implementing the Startup Manifesto recommendations;</li>
        <li>to facilitate the process of policy coordination and data collection between the European Union member states and the European Commission by providing an easy-to-use, interactive, evidence-based tool;</li>
        <li>to unleash a healthy competition between countries in designing and implementing entrepreneurship-friendly policies.</li>
    </ul>
    <p><span id="more-trigger" class="fakelink">Read more</span></p>

</section>

<section id="join-text">
    <h3>About Startup Manifesto </h3>

    <p>The Startup Manifesto is a manifesto for entrepreneurship and innovation 
        to power growth in the European Union. This ambitious policy document 
        was written by the Leaders Club, an independent group of founders 
        of world-leading technology companies based in Europe, including 
        Atomico, HackFwd, Rovio, Seedcamp, Spotify, Tech City Investment 
        Organisation (TCIO), Tuenti and The Next Web. The manifesto was 
        drafted to spur discussion on improving the startup ecosystem and 
        digital-era performance in the European Union’s 28 member states. 
        For more, visit <a href="http://www.startupmanifesto.eu">http://www.startupmanifesto.eu</a>
</section>

<div class="row" id="map-container">
    <div id="map-overview" class="col-xs-12 col-md-4 col-lg-3">
        <h3>Overview</h3>
        <p>The <strong>Startup Manifesto Policy Tracker</strong> is a dynamic tool open to community discussion and crowdsourcing. It measures individual countries’ progress based on six thematic priorities, reflecting the overall structure of the Startup Manifesto:</p>
        <ul>
            <li>Institutional Framework</li>
            <li>Education and Skills</li>
            <li>Access to Talent</li>
            <li>Access to Capital</li>
            <li>Data Policy, Protection and Privacy</li>
            <li>Thought Leadership</li>
        </ul>

        <p>Progress in the implementation of key policies is monitored by 
            communities of web entrepreneurs, practitioners and policymakers 
            and coordinated by a group of <a href="experts">selected experts</a> 
            from each of the 28 European Union member states.</p>

        <p>An overview map visualises the progress in each of the six thematic priorities in 28 European Union member states, 
            as well as the status of the level of data provided.</p>

        <p>You may compare the progress of EU countries in the Startup Manifesto´s implementation on the specific action level on the interactive <a href="dashboard">Dashboard</a></p>
    </div>
    <div class="col-xs-12 col-md-8  col-lg-9">
        <div id="map-legenda">
            <h3>Legend</h3>
            <div class="row-legenda"><div class="sq-legenda color-0"></div> <?php echo $this->vars['legend_labels'][0];?></div>
            <div class="row-legenda"><div class="sq-legenda color-1"></div> <?php echo $this->vars['legend_labels'][1];?></div>
            <div class="row-legenda"><div class="sq-legenda color-2"></div> <?php echo $this->vars['legend_labels'][2];?></div>
            <div class="row-legenda"><div class="sq-legenda color-3"></div> <?php echo $this->vars['legend_labels'][3];?></div>
        </div>
        <div id="map" >
            <svg></svg>
        </div>
    </div>
</div>

<?php echo $this->LAST_UPDATES; ?>

<div id="tooltip" class="hidden">
    <div id="countrydiv"></div>
</div>
