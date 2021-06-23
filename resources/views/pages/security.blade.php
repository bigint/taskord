@extends('layouts.app')

@section('pageTitle', 'Security ·')
@section('title', 'Security ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="card">
            <div class="card-header py-3">
                <span class="h5">Security</span>
                <div>Reporting Vulnerabilities to Taskord</div>
            </div>
            <div class="card-body">
                <div>
                    Found a vulnerability in our systems? Fill out this form <a
                        href="https://airtable.com/shrN0O8155kbi61Jl" target="_blank" rel="noreferrer">here</a>. You'll hear
                    back from us within two weeks at the absolute latest, and we'll let you know:
                </div>
                <div class="mt-3">
                    <ul>
                        <li>If it's been reported previously,</li>
                        <li>Whether or not we think it's a valid issue,</li>
                        <li>And if it's eligible for a reward.</li>
                    </ul>
                </div>
                <h5 class="mt-4">Security Guidelines and Etiquette</h5>
                <div>
                    Please read and follow these guidelines prior to sending in any reports.
                </div>
                <div class="mt-3">
                    <ol>
                        <li>
                            <div>Do not test vulnerabilities in public. We ask that you do not attempt any vulnerabilities,
                                rate-limiting tests, exploits, or any other security/bug-related findings if it will impact
                                another community member. This means you should not leave comments on someone else’s tasks
                                and questions, or otherwise, impact their experience on the platform.</div>
                            <div class="mt-1">Note that we are open source and have <a
                                    href="https://gitlab.com/taskord/taskord/-/blob/main/docs/installation.md"
                                    target="_blank" rel="noreferrer">documentation</a> available if you're interested in
                                setting up a dev environment for the purposes of testing.</div>
                        </li>
                        <li class="mt-2">
                            Do not report similar issues or variations of the same issue in different reports. Please report
                            any similar issues in a single report. It's better for both parties to have this information in
                            one place where we can evaluate it all together. Please note any and all areas where your
                            vulnerability might be relevant. You will not be penalized or receive a lower reward for
                            streamlining your report in one place vs. spreading it across different areas.
                        </li>
                        <li class="mt-2">
                            The following domains are not eligible for our bounty program as they are hosted by or built on
                            external services:
                            <div class="mt-2">
                                <ul>
                                    <li>
                                        <a href="https://status.taskord.com">status.taskord.com</a> (UptimeRobot)
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-1">
                                We've listed the service provider of each of these domains so that you might contact them if
                                you wish to report the vulnerability you found.
                            </div>
                        </li>
                        <li class="mt-2">
                            DoS (Denial of Service) vulnerabilities should not be tested for more than a span of 5 minutes.
                            Be courteous and reasonable when testing any endpoints on dev.to as this may interfere with our
                            monitoring. If we discover that you are testing DoS disruptively for prolonged periods of time,
                            we may restrict your award, block your IP address, or remove your eligibility to participate in
                            the program.
                        </li>
                        <li class="mt-2">
                            Please be patient with us after sending in your report. We’d appreciate it if you avoid
                            messaging us to ask about the status of your report. Our team will get back to you as quickly as
                            we are able. It is okay to inquire about the status of your report if you haven’t heard from us
                            2 weeks after sending it in. Otherwise, we ask that you please wait patiently for us to contact
                            you, unless you have more information relevant to the vulnerability that you’d like to share.
                        </li>
                    </ol>
                </div>
                <h5 class="mt-4">Vulnerability Assessment and Reward</h5>
                <div>
                    Vulnerabilities are assessed via <a href="https://bugcrowd.com/vulnerability-rating-taxonomy"
                        target="_blank" rel="noreferrer">BugCrowd's taxonomy rating</a> and our judgment. For now we provide
                    you lifetime Taskord Patron for free!
                </div>
            </div>
        </div>
    </div>
@endsection
