@extends('layouts.app')

@section('pageTitle', 'Sponsors ·')
@section('title', 'Sponsors ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Thank you! 💜️</span>
            <div>for supporting our community</div>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center mb-5">
                <div>
                    <img class="rounded avatar-150" src="https://i.imgur.com/QSAzjno.jpg" />
                </div>
                <div class="ml-4">
                    <span class="h5">
                        Amazon Web Service
                    </span>
                    <div class="h6 mt-3">
                        AWS (Amazon Web Services) is a comprehensive, evolving cloud computing platform provided by Amazon that includes a mixture of infrastructure as a service (IaaS), platform as a service (PaaS) and packaged software as a service (SaaS) offerings.
                    </div>
                    <div class="mt-2">
                        <a href="https://aws.amazon.com" target="_blank">➜ Go to AWS</a>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center mb-5">
                <div>
                    <img class="rounded avatar-150" src="https://i.imgur.com/LnDFjfr.jpg" />
                </div>
                <div class="ml-4">
                    <span class="h5">
                        DigitalOcean
                    </span>
                    <div class="h6 mt-3">
                        DigitalOcean is a cloud hosting provider that offers cloud computing services to business entities so that they can scale themselves by deploying DigitalOcean applications that run parallel across multiple cloud servers without compromising on performance!
                    </div>
                    <div class="mt-2">
                        <a href="https://www.digitalocean.com" target="_blank">➜ Go to DigitalOcean</a>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center mb-5">
                <div>
                    <img class="rounded avatar-150" src="https://i.imgur.com/uRbpWBH.jpg" />
                </div>
                <div class="ml-4">
                    <span class="h5">
                        GitLab
                    </span>
                    <div class="h6 mt-3">
                        GitLab is a web-based DevOps lifecycle tool that provides a Git-repository manager providing wiki, issue-tracking and continuous integration and deployment pipeline features.
                    </div>
                    <div class="mt-2">
                        <a href="https://gitlab.com" target="_blank">➜ Go to GitLab</a>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center mb-5">
                <div>
                    <img class="rounded avatar-150" src="https://i.imgur.com/K1oZwr6.jpg" />
                </div>
                <div class="ml-4">
                    <span class="h5">
                        Sentry
                    </span>
                    <div class="h6 mt-3">
                        Track errors & monitor performance in all major languages & frameworks with Sentry. Open-source error tracking with full stacktraces & asynchronous context.
                    </div>
                    <div class="mt-2">
                        <a href="https://sentry.io" target="_blank">➜ Go to Sentry</a>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center mb-4">
                <div>
                    <img class="rounded avatar-150" src="https://i.imgur.com/a4hBf5f.png" />
                </div>
                <div class="ml-4">
                    <span class="h5">
                        BrowserStack
                    </span>
                    <div class="h6 mt-3">
                        Speed up your release cycles and deploy bug-free websites and mobile apps with BrowserStack, the industry’s most reliable cloud web and mobile testing platform.
                    </div>
                    <div class="mt-2">
                        <a href="https://www.browserstack.com" target="_blank">➜ Go to BrowserStack</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
