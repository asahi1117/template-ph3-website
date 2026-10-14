<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            POSSE website
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <nav class="bg-white shadow-sm sm:rounded-lg">
                <ul class="p-6 flex gap-6">
                    <li>
                        <a href="{{ route('website.index') }}" class="font-semibold text-gray-800">POSSEとは</a>
                    </li>
                    <li>
                        <a href="{{ route('quizzes.index') }}" class="font-semibold text-gray-800">クイズ</a>
                    </li>
                    <li>
                        <a href="{{ route('media.index') }}" class="font-semibold text-gray-800">POSSE MEDIA</a>
                    </li>
                </ul>
            </nav>

            <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-sm text-gray-500">学生プログラミングコミュニティ</p>
                    <h1 class="mt-2 text-3xl font-bold">POSSE（ポッセ）</h1>
                    <p class="mt-4 text-2xl font-semibold">自分史上最高を仲間と。</p>
                </div>
            </section>

            <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl font-semibold">
                        POSSEとは
                        <span class="ml-2 text-sm font-normal text-gray-500" lang="en">About POSSE</span>
                    </h2>
                    <p class="mt-4 leading-relaxed">
                        学生プログラミングコミュニティ「POSSE(ポッセ)」は、人格とプログラミング、二つの面での成長をスローガンに活動しており、大学生だけが集まって学びを深めるコミュニティです。<br>
                        プログラミングだけではありません。オフラインでのイベントや、旅行など様々な企画を行っています！<br>
                        それらを通じて、夏休みの大半をPOSSEで出来た仲間と過ごす人もたくさんいるほどメンバーとの仲が深まります。
                    </p>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
