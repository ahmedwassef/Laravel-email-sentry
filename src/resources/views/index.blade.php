@extends('EmailSentry::layout.master')

@section('content')


<div class="w-full max-w-full px-3 mb-6  mx-auto">
                <div class="relative flex-[1_auto] flex flex-col break-words min-w-0 bg-clip-border rounded-[.95rem] bg-white m-5">
                    <div class="relative flex flex-col min-w-0 break-words border border-dashed bg-clip-border rounded-2xl border-stone-200 bg-light/30">
                        <!-- card header -->
                        <div class="px-9 pt-5 flex justify-between items-stretch flex-wrap min-h-[70px] pb-0 bg-transparent">
                            <h3 class="flex flex-col items-start justify-center m-2 ml-0 font-medium text-xl/tight text-dark">
                                <span class="mr-3 font-semibold text-dark">Emails Logs</span>
                                <span class="mt-1 font-medium text-secondary-dark text-lg/normal">Provide detailed records of email communications including sender and recipient </span>
                            </h3>

                        </div>
                        <!-- end card header -->
                        <!-- card body  -->
                        <div class="flex-auto block py-8 pt-6 px-9">
                            <div class="overflow-x-auto">
                                <table class="w-full my-0 align-middle text-dark border-neutral-200">
                                    <thead class="align-bottom">
                                    <tr class="font-semibold text-[0.95rem] text-secondary-dark">
                                        <th class="pb-3 text-start min-w-[175px]">ID</th>
                                        <th class="pb-3 text-end min-w-[100px]">Subject</th>
                                        <th class="pb-3 text-end min-w-[100px]">To</th>
                                        <th class="pb-3 pr-12 text-end min-w-[175px]">Status</th>
                                        <th class="pb-3 pr-12 text-end min-w-[100px]">Send At</th>
                                        <th class="pb-3 text-end min-w-[50px]">Details</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    @foreach($emails as $email)

                                         <tr class="border-b border-dashed last:border-b-0">
                                        <td class="p-3 pl-0">
                                            <div class="flex items-center">

                                                <div class="flex flex-col justify-start">
                                                    <b class="mb-1 font-semibold transition-colors duration-200 ease-in-out text-lg/normal text-secondary-inverse hover:text-primary">
                                                    {{ $email->email_id }}
                                                    </b>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-3 pr-0 text-end">

                                            <span class="font-semibold text-light-inverse text-md/normal">
                                               {{ $email->subject }}
                                            </span>
                                        </td>
                                        <td class="p-3 pr-0 text-end">
                                            {{ key($email->to) }}
                                        </td>
                                        <td class="p-3 pr-12 text-end">
                                                   {{  $email->sent_at?"Send":"In Progress" }}
                                        </td>
                                        <td class="pr-0 text-start">
                                             {{$email->created_at }}

                                        </td>
                                        <td class="p-3 pr-0 text-end">
                                            <a href="{{route('email.sentry.emails.details',['id'=>$email->id])}}" class="ml-auto relative text-secondary-dark bg-light-dark hover:text-primary flex items-center h-[25px] w-[25px] text-base font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-200 ease-in-out shadow-none border-0 justify-center">
                                                  <span class="flex items-center justify-center p-0 m-0 leading-none shrink-0 ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                         stroke="currentColor" class="w-4 h-4">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                                    </svg>
                                                    </span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">

                    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">

                        <div>
                            {!! $emails->links() !!}
                         </div>
                    </div>
                </div>

            </div>

@endsection

