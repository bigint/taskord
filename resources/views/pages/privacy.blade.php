@extends('layouts.app')

@section('pageTitle', 'Privacy ·')
@section('title', 'Privacy ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="card">
            <div class="card-header py-3">
                <span class="h5">Privacy Policy</span>
                <div>Web Site Privacy Policy</div>
            </div>
            <div class="card-body">
                <div>
                    Taskord built the Taskord app as an Open Source app. This SERVICE is provided by Taskord at no cost and
                    is intended for use as is.
                </div>
                <div>
                    This page is used to inform visitors regarding our policies with the collection, use, and disclosure of
                    Personal Information if anyone decided to use our Service.
                </div>
                <div>
                    If you choose to use our Service, then you agree to the collection and use of information concerning
                    this policy. The Personal Information that we collect is used for providing and improving the Service.
                    We will not use or share your information with anyone except as described in this Privacy Policy.
                </div>
                <div>
                    The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which are
                    accessible at Taskord unless otherwise defined in this Privacy Policy.
                </div>
                <h5 class="mt-4">Information Collection and Use</h5>
                <div>
                    For a better experience, while using our Service, we may require you to provide us with certain
                    personally identifiable information. The information that we request will be retained on your device and
                    is not collected by us in any way.
                </div>
                <h5 class="mt-4">Log Data</h5>
                <div>
                    We want to inform you that whenever you use my Service, in a case of an error in the app we collect data
                    and information (through third-party products) on your phone called Log Data. This Log Data may include
                    information such as your device Internet Protocol (“IP”) address, device name, operating system version,
                    the configuration of the app when utilizing my Service, the time and date of your use of the Service,
                    and other statistics.
                </div>
                <h5 class="mt-4">Cookies</h5>
                <div>
                    Cookies are files with a small amount of data that are commonly used as anonymous unique identifiers.
                    These are sent to your browser from the websites that you visit and are stored on your device's internal
                    memory.
                </div>
                <div>
                    This Service does not use these “cookies” explicitly. However, the app may use third-party code and
                    libraries that use “cookies” to collect information and improve their services. You have the option to
                    either accept or refuse these cookies and know when a cookie is being sent to your device. If you choose
                    to refuse our cookies, you may not be able to use some portions of this Service.
                </div>
                <h5 class="mt-4">Service Providers</h5>
                <div>
                    We may employ third-party companies and individuals due to the following reasons:
                </div>
                <div class="mt-3">
                    <ul>
                        <li>To facilitate our Service;</li>
                        <li>To provide the Service on our behalf;</li>
                        <li>To perform Service-related services; or</li>
                        <li>To assist us in analyzing how our Service is used.</li>
                    </ul>
                </div>
                <div>
                    We want to inform users of this Service that these third parties have access to your Personal
                    Information. The reason is to perform the tasks assigned to them on our behalf. However, they are
                    obligated not to disclose or use the information for any other purpose.
                </div>
                <h5 class="mt-4">Security</h5>
                <div>
                    We value your trust in providing us your Personal Information, thus we are striving to use commercially
                    acceptable means of protecting it. But remember that no method of transmission over the internet, or
                    method of electronic storage is 100% secure and reliable, and we cannot guarantee its absolute security.
                </div>
                <h5 class="mt-4">Links to Other Sites</h5>
                <div>
                    This Service may contain links to other sites. If you click on a third-party link, you will be directed
                    to that site. Note that these external sites are not operated by me. Therefore, we strongly advise you
                    to review the Privacy Policy of these websites. We have no control over and assume no responsibility for
                    the content, privacy policies, or practices of any third-party sites or services.
                </div>
                <h5 class="mt-4">Children’s Privacy</h5>
                <div>
                    These Services do not address anyone under the age of 13. We do not knowingly collect personally
                    identifiable information from children under 13. In the case we discover that a child under 13 has
                    provided me with personal information, we immediately delete all the information related to this from
                    our servers. If you are a parent or guardian and you are aware that your child has provided us with
                    personal information, please contact us so that we will be able to do the necessary actions.
                </div>
                <h5 class="mt-4">Changes to This Privacy Policy</h5>
                <div>
                    We may update our Privacy Policy from time to time. Thus, you are advised to review this page
                    periodically for any changes. We will notify you of any changes by posting the new Privacy Policy on
                    this page.
                </div>
                <div>
                    This policy was first produced 2020-09-10, and is updated and latest effective as of 2021-06-01.
                    {{-- The very first policy 2020-09-10 --}}
                    {{-- First "revised" policy 2021-06-01 --}}
                </div>
                <h5 class="mt-4">Contact Us</h5>
                <div>
                    If you have any questions or suggestions about our Privacy Policy, do not hesitate to <a
                        href="https://taskord.com/contact">Contact Us</a>.
                </div>
            </div>
        </div>
    </div>
@endsection
