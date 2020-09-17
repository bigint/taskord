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
            <div class="d-flex align-items-center mb-4">
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
                        <a href="" target="_blank">https://aws.amazon.com</a>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center mb-4">
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
                        <a href="" target="_blank">https://www.digitalocean.com</a>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center mb-4">
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
                        <a href="" target="_blank">https://gitlab.com</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
