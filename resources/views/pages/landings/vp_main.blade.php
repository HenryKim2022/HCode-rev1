@extends('layouts.landings.vl_main')

@section('header_page_cssjs')
    <style>
        html[data-bs-theme=dark] .area-title,
        html[data-bs-theme=dark] .area-subtitle,
        html[data-bs-theme=dark] .posts-tags {
            /* background: #2f3742; */
            color: #bccee4;
        }

        html[data-bs-theme=dark] .area-title:hover,
        html[data-bs-theme=dark] .area-subtitle:hover,
        html[data-bs-theme=dark] .posts-tags:hover {
            color: #f1f1f1;
        }

        html[data-bs-theme=light] .area-title,
        html[data-bs-theme=light] .area-subtitle {
            color: #f1f1f1;
        }

        html[data-bs-theme=light] .posts-tags {
            color: #bccee4;
        }

        html[data-bs-theme=light] .area-title:hover,
        html[data-bs-theme=light] .area-subtitle:hover,
        html[data-bs-theme=light] .posts-tags:hover {
            color: #bccee4;
        }
    </style>
@endsection


@section('page-content')
    <section>
        <ul class="notices list-unstyled">
            <li class="notice">
                <div class="row">
                    <div class="col-12 px-0 px-sm-0 px-md-0 px-lg-0">
                        <div class="uix_noticeInner d-flex align-items-stretch alert alert-purple alert-dismissible border-2 border-primary shadow p-0 fade show"
                            role="alert">
                            <!-- Icon Container -->
                            <div class="uix_noticeIcon text-bg-purple d-flex align-items-center justify-content-center flex-shrink-0 rounded-start-1"
                                style="width: 48px;">
                                <i class="mdi mdi-information-outline fs-3"></i>
                            </div>
                            <!-- Content Container -->
                            <div
                                class="notice-content flex-grow-1 py-2 px-2 d-flex flex-column justify-content-center lh-sm">
                                <strong>Purple - </strong> A simple purple alert—check it out!<br>
                            </div>
                            <!-- Close Button -->
                            <button type="button" class="btn-close align-self-center p-2 fs-7" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row-->
            </li> <!-- end li-->
            <li></li>
        </ul>
    </section>


    <section>
        <section class="d-flex flex-wrap">
            <!-- Main Content -->
            <div class="main-content order-2 order-sm-1 flex-grow-1 me-4 col-12 col-sm-12 col-md-8 col-lg-8">
                <!-- Main content goes here -->
                <section class="NPOSTS">
                    <div class="row px-0">
                        <div class="col-12 mb-2 px-0">
                            <div class="d-flex justify-content-between">
                                <div class="bg-primary bg-opacity-1 p-2 rounded-2 d-inline-block">
                                    <h5 class="area-title my-0">
                                        <i class="mdi mdi-checkbox-marked-circle-plus-outline"></i> New Posts
                                    </h5>
                                    <h6 class="area-subtitle my-0"></h6>
                                </div>
                                <button type="button" class="btn btn-primary">View More</button>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                    <div class="row px-0">
                        <div class="mb-2 x-scrollable">
                            <div class="row d-flex flex-nowrap gap-1">
                                @php
                                    $dummyCategory = ['Web Dev', 'Utility', 'Security', 'Tutorials', 'OS'];
                                @endphp
                                @for ($i = 0; $i < 7; $i++)
                                    @php
                                        $randomCatIndex = random_int(0, count($dummyCategory) - 1);
                                    @endphp
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-3 px-0 pb-0">
                                        <div class="card position-relative col-11 col-sm-11 col-lg-11 shadow-md mb-2">
                                            <div class="lazy-load pswp-gallery position-relative">
                                                <a href="{{ asset('template/assets/images/small/small-2.jpg') }}?v={{ time() }}"
                                                    data-pswp-width="1650" data-caption="This is a caption 1"
                                                    data-pswp-height="1080">
                                                    <img src="{{ asset('template/assets/images/small/small-2.jpg') }}?v={{ time() }}"
                                                        class="card-img-top" loading="lazy" alt="...">
                                                </a>
                                            </div>

                                            <div class="card-body p-1">
                                                <h5 class="card-title"><a href="#" class="text-success">Card with
                                                        stretched link</a></h5>
                                                <p class="card-text">
                                                    Some quick example text to build on the card up the bulk of the
                                                    card's
                                                    content.
                                                </p>
                                            </div> <!-- end card-body -->
                                            <span
                                                class="posts-tags fs-6 rounded-2 m-1 position-absolute top-0 start-0 bg-info bg-opacity-75 px-2 py-1">
                                                #{{ $i + 1 }}.
                                            </span>
                                            <span
                                                class="posts-tags fs-6 rounded-2 m-1 position-absolute top-0 end-0 bg-info bg-opacity-75 px-2 py-1">
                                                {{ $dummyCategory[$randomCatIndex] }}
                                            </span>
                                        </div> <!-- end card -->
                                    </div> <!-- end col-->
                                @endfor
                            </div> <!-- end row -->
                        </div> <!-- end container -->
                    </div>
                </section>


                <section class="NPOSTS mt-3">
                    <div class="row px-0">
                        <div class="col-12 mb-2 px-0">
                            <div class="d-flex justify-content-between">
                                <div class="bg-primary bg-opacity-1 p-2 rounded-2 d-inline-block">
                                    <h5 class="area-title my-0">
                                        <i class="mdi mdi-checkbox-marked-circle-plus-outline"></i> New Posts
                                    </h5>
                                    <h6 class="area-subtitle my-0"></h6>
                                </div>
                                <button type="button" class="btn btn-primary">View More</button>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                    <div class="row px-0">
                        <div class="mb-2 x-scrollable">
                            <div class="row d-flex flex-nowrap gap-1">
                                @php
                                    $dummyCategory = ['Web Dev', 'Utility', 'Security', 'Tutorials', 'OS'];
                                @endphp
                                @for ($i = 0; $i < 7; $i++)
                                    @php
                                        $randomCatIndex = random_int(0, count($dummyCategory) - 1);
                                    @endphp
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-3 px-0 pb-0">
                                        <div class="card position-relative col-11 col-sm-11 col-lg-11 shadow-md mb-2">
                                            <div class="lazy-load pswp-gallery position-relative">
                                                <a href="{{ asset('template/assets/images/small/small-2.jpg') }}?v={{ time() }}"
                                                    data-pswp-width="1650" data-caption="This is a caption 1"
                                                    data-pswp-height="1080">
                                                    <img src="{{ asset('template/assets/images/small/small-2.jpg') }}?v={{ time() }}"
                                                        class="card-img-top" loading="lazy" alt="...">
                                                </a>
                                            </div>

                                            <div class="card-body p-1">
                                                <h5 class="card-title"><a href="#" class="text-success">Card with
                                                        stretched link</a></h5>
                                                <p class="card-text">
                                                    Some quick example text to build on the card up the bulk of the card's
                                                    content.
                                                </p>
                                            </div> <!-- end card-body -->
                                            <span
                                                class="posts-tags fs-6 rounded-2 m-1 position-absolute top-0 start-0 bg-info bg-opacity-75 px-2 py-1">
                                                #{{ $i + 1 }}.
                                            </span>
                                            <span
                                                class="posts-tags fs-6 rounded-2 m-1 position-absolute top-0 end-0 bg-info bg-opacity-75 px-2 py-1">
                                                {{ $dummyCategory[$randomCatIndex] }}
                                            </span>
                                        </div> <!-- end card -->
                                    </div> <!-- end col-->
                                @endfor
                            </div> <!-- end row -->
                        </div> <!-- end container -->
                    </div>

                </section>


                <section class="RUPS mt-3">
                    @php
                        $dummyCategory = ['Web Dev', 'Utility', 'Security', 'Tutorials', 'OS'];
                        $cards = [];
                        for ($i = 0; $i < 60; $i++) {
                            $randomCatIndex = random_int(0, count($dummyCategory) - 1);
                            $cards[] = [
                                'category' => $dummyCategory[$randomCatIndex],
                                'title' => 'Card title (' . $dummyCategory[$randomCatIndex] . ')',
                                'text' =>
                                    'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
                                'updated' => 'Last updated 3 mins ago',
                            ];
                        }
                        $currentPage = 1;
                        $cardsPerPage = 6;
                        $totalPages = ceil(count($cards) / $cardsPerPage);
                    @endphp
                    <div class="row px-0">
                        <div class="col-12 mb-2 px-0">
                            <div class="d-flex justify-content-between">
                                <div class="bg-primary bg-opacity-1 p-2 rounded-2 d-inline-block d-flex align-items-center">
                                    <h5 class="area-title my-0 py-0">
                                        <i class="mdi mdi-checkbox-marked-circle-plus-outline"></i> Recently Updates
                                    </h5>
                                    <h6 class="area-subtitle my-0"></h6>
                                </div>
                                <div class="btn-group my-1">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false" id="sort-by-button">Sort by ...</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" onclick="selectCategory('All')">All</a>
                                        @foreach ($dummyCategory as $cat)
                                            <a class="dropdown-item" onclick="selectCategory('{{ $cat }}')">Sort
                                                by
                                                {{ $cat }}</a>
                                        @endforeach
                                    </div>
                                </div><!-- /btn-group -->
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <div class="row px-0">
                        <div class="col-12 px-0">
                            <ul class="recently-updates row list-unstyled mr-0">
                                @foreach ($cards as $index => $card)
                                    @if ($index < $cardsPerPage)
                                        <li class="col-lg-6 col-md-12">
                                            <div class="card shadow-md">
                                                <div class="row d-flex g-0 justify-content-between gap-2">
                                                    <div class="row g-0 align-items-stretch">
                                                        <div class="col-md-4 position-relative">
                                                            <div class="pswp-gallery lazy-load position-relative">
                                                                <a href="{{ asset('template/assets/images/small/small-2.jpg') }}?v={{ time() }}"
                                                                    data-pswp-width="1650" data-pswp-height="1080"
                                                                    data-caption="This is a caption"
                                                                    style="object-fit: cover !important; height: 100% !important; width:100% !important;">
                                                                    <img src="{{ asset('template/assets/images/small/small-2.jpg') }}?v={{ time() }}"
                                                                        class="card-img-top" loading="lazy"
                                                                        style="object-fit: cover !important; height: 100% !important; width:100% !important;"
                                                                        alt="...">
                                                                </a>
                                                            </div>

                                                            <span
                                                                class="posts-tags fs-6 rounded-2 m-1 position-absolute top-0 start-0 bg-info bg-opacity-75 px-2 py-1"
                                                                data-category="{{ $cards[$index]['category'] }}">
                                                                {{ $cards[$index]['category'] }}
                                                            </span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="card-body p-2">
                                                                <h5 class="card-title text-success">#{{ $index + 1 }}.
                                                                    {{ $cards[$index]['title'] }}</h5>
                                                                <p class="card-text">{{ $cards[$index]['text'] }}</p>
                                                                <p class="card-text"><small
                                                                        class="text-muted">{{ $cards[$index]['updated'] }}</small>
                                                                </p>
                                                            </div> <!-- end card-body-->
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row-->
                                                </div> <!-- end row-->

                                            </div> <!-- end card-->
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination d-flex flex-wrap justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link" aria-label="Previous"
                                            onclick="updatePage(event, {{ $currentPage - 1 }})">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    @for ($i = 1; $i <= 3; $i++)
                                        <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                                            <a class="page-link" href="javascript:void(0)"
                                                onclick="updatePage(event, {{ $i }})">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item disabled">
                                        <a class="page-link" href="javascript:void(0)">...</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="javascript:void(0)"
                                            onclick="updatePage(event, {{ $totalPages }})">{{ $totalPages }}</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" aria-label="Next"
                                            onclick="updatePage(event, {{ $currentPage + 1 }})">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>


                            <script>
                                const realStart = 0;
                                const realEnd = {{ $cardsPerPage ?: 0 }};
                                const cards = {!! json_encode($cards) !!};

                                function selectCategory(category) {
                                    localStorage.setItem('selectedCategory', category);
                                    updateSortByButton(category);
                                    sortCards(category);
                                }

                                function updateSortByButton(category) {
                                    if (category === 'All') {
                                        document.getElementById('sort-by-button').innerHTML = 'Sort by All';
                                    } else {
                                        document.getElementById('sort-by-button').innerHTML = 'Sort by ' + category;
                                    }
                                }


                                function sortCards(category) {
                                    var cardsList = document.querySelector('.recently-updates');
                                    cardsList.innerHTML = '';
                                    if (category === 'All') {
                                        var start = 0;
                                        var end = realEnd;
                                        for (var i = start; i < end; i++) {
                                            if (i < cards.length) {
                                                var cardHtml = `
                                <li class="col-lg-6 col-md-12">
                                    <!-- card content here -->
                                </li>
                            `;
                                                cardsList.innerHTML += cardHtml;
                                            }
                                        }
                                    } else {
                                        var count = 0;
                                        var start = 0;
                                        var end = realEnd;
                                        for (var i = 0; i < cards.length; i++) {
                                            if (cards[i]['category'] === category) {
                                                if (count >= start && count < end) {
                                                    var cardHtml = `
                                    <li class="col-lg-6 col-md-12">
                                        <!-- card content here -->
                                    </li>
                                `;
                                                    cardsList.innerHTML += cardHtml;
                                                }
                                                count++;
                                            }
                                        }
                                    }

                                    // updatePage(null, 1);

                                    var event = new Event('click'); // Create a new event object
                                    updatePage(event, 1); // Pass the event object to updatePage
                                }


                                var currentPage = 1

                                function updatePage(event, pageNumber) {
                                    if (event) {
                                        event.preventDefault();
                                    }
                                    currentPage = pageNumber; // Update currentPage here

                                    var cardsList = document.querySelector('.recently-updates');
                                    cardsList.innerHTML = '';

                                    var start = (pageNumber - 1) * realEnd;
                                    var end = Math.min(start + realEnd, cards.length);
                                    var selectedCategory = localStorage.getItem('selectedCategory');
                                    if (selectedCategory === 'All' || selectedCategory === null) {
                                        for (var i = start; i < end; i++) {
                                            var cardHtml = `
                                                <li class="col-lg-6 col-md-12">
                                                    <div class="card shadow-md">
                                                    <div class="row d-flex g-0 justify-content-between gap-2">
                                                        <div class="row g-0 align-items-stretch">
                                                        <div class="col-md-4 position-relative">
                                                            <div class="lazy-load pswp-gallery position-relative">
                                                                <a href="{{ asset('template/assets/images/small/small-2.jpg') }}?v={{ time() }}" data-pswp-width="1900" data-caption="This is a caption 1" data-pswp-height="1080">
                                                                    <img src="{{ asset('template/assets/images/small/small-2.jpg') }}?v={{ time() }}"
                                                                    class="card-img-top" loading="lazy" alt="...">
                                                                </a>
                                                            </div>
                                                        <span
                                                            class="posts-tags fs-6 rounded-2 m-1 position-absolute top-0 start-0 bg-info bg-opacity-75 px-2 py-1"
                                                            data-category="${cards[i]['category']}">
                                                            ${cards[i]['category']}
                                                        </span>
                                                        </div>
                                                        <div class="col-md-8">
                                                        <div class="card-body p-2">
                                                            <h5 class="card-title text-success">#${i + 1}.
                                                                ${cards[i]['title']}</h5>
                                                            <p class="card-text">${cards[i]['text']}</p>
                                                            <p class="card-text"><small class="text-muted">${cards[i]['updated']}</small>
                                                            </p>
                                                        </div> <!-- end card-body-->
                                                        </div> <!-- end col -->
                                                        </div> <!-- end row-->
                                                    </div> <!-- end row-->

                                                </div> <!-- end card-->
                                            </li>
                                            `;
                                            cardsList.innerHTML += cardHtml;
                                        }
                                    } else {
                                        var count = 0;
                                        for (var i = 0; i < cards.length; i++) {
                                            if (cards[i]['category'] === selectedCategory) {
                                                if (count >= start && count < end) {
                                                    var cardHtml = `
                                                        <li class="col-lg-6 col-md-12">
                                                            <div class="card shadow-md">
                                                            <div class="row d-flex g-0 justify-content-between gap-2">
                                                                <div class="row g-0 align-items-stretch">
                                                                <div class="col-md-4 position-relative">
                                                                    <div class="lazy-load pswp-gallery position-relative">
                                                                        <a href="{{ asset('template/assets/images/small/small-2.jpg') }}?v={{ time() }}" data-pswp-width="1900" data-caption="This is a caption 1" data-pswp-height="1080">
                                                                            <img src="{{ asset('template/assets/images/small/small-2.jpg') }}?v={{ time() }}"
                                                                            class="card-img-top" loading="lazy" alt="...">
                                                                        </a>
                                                                    </div>
                                                                <span
                                                                    class="posts-tags fs-6 rounded-2 m-1 position-absolute top-0 start-0 bg-info bg-opacity-75 px-2 py-1"
                                                                    data-category="${cards[i]['category']}">
                                                                    ${cards[i]['category']}
                                                                </span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                <div class="card-body p-2">
                                                                    <h5 class="card-title text-success">#${count + 1}.
                                                                    ${cards[i]['title']}</h5>
                                                                    <p class="card-text">${cards[i]['text']}</p>
                                                                    <p class="card-text"><small class="text-muted">${cards[i]['updated']}</small>
                                                                    </p>
                                                                </div> <!-- end card-body-->
                                                                </div> <!-- end col -->
                                                                </div> <!-- end row-->
                                                            </div> <!-- end row-->

                                                        </div> <!-- end card-->
                                                    </li>
                                                `;
                                                    cardsList.innerHTML += cardHtml;
                                                }
                                                count++;
                                            }
                                        }
                                    }

                                    // Dispatch a custom event to notify app.js to reinitialize PhotoSwipe
                                    document.dispatchEvent(new Event('photoswipe:init'));


                                    updatePagination(pageNumber);
                                    if (cardsList.innerHTML === '') {
                                        cardsList.innerHTML = '<p class="text-center">No ' + selectedCategory + ' found.</p>';
                                    }
                                }

                                function updatePagination(pageNumber) {
                                    console.log('currentPage:', currentPage);
                                    var paginationList = document.querySelector('nav[aria-label="Page navigation example"] ul');
                                    if (paginationList === null) {
                                        console.error('paginationList is null');
                                        return;
                                    }

                                    var totalPages = Math.ceil(cards.length / realEnd);

                                    // clear pagination list
                                    paginationList.innerHTML = '';

                                    // add prev button
                                    var prevButton = document.createElement('li');
                                    prevButton.classList.add('page-item');
                                    prevButton.innerHTML = '<a class="page-link" aria-label="Previous" onclick="updatePage(event, ' + (pageNumber -
                                        1) + ')"><span aria-hidden="true">&laquo;</span></a>';
                                    if (pageNumber === 1) {
                                        prevButton.classList.add('disabled');
                                        prevButton.querySelector('a').removeAttribute('onclick');
                                    }
                                    paginationList.appendChild(prevButton);

                                    // add first page number
                                    if (pageNumber > 3) {
                                        var paginationFirst = document.createElement('li');
                                        paginationFirst.classList.add('page-item');
                                        paginationFirst.innerHTML = '<a class="page-link" href="#" onclick="updatePage(event, 1)">1</a>';
                                        paginationList.appendChild(paginationFirst);
                                        var paginationEllipsis = document.createElement('li');
                                        paginationEllipsis.classList.add('page-item');
                                        paginationEllipsis.classList.add('disabled');
                                        paginationEllipsis.innerHTML = '<a class="page-link" href="#">...</a>';
                                        paginationList.appendChild(paginationEllipsis);
                                    }

                                    // add middle page numbers
                                    var start = Math.max(1, pageNumber - 1);
                                    var end = Math.min(totalPages, pageNumber + 1);
                                    if (window.innerWidth < 768) {
                                        start = Math.max(1, pageNumber - 1);
                                        end = Math.min(totalPages, pageNumber + 1);
                                        if (start > 1) {
                                            start = Math.max(1, pageNumber - 1);
                                        }
                                        if (end < totalPages) {
                                            end = Math.min(totalPages, pageNumber + 1);
                                        }
                                        var middlePageNumbers = [];
                                        for (var i = start; i <= end; i++) {
                                            middlePageNumbers.push(i);
                                        }
                                        if (middlePageNumbers.length > 3) {
                                            middlePageNumbers = [middlePageNumbers[0], middlePageNumbers[1], middlePageNumbers[2]];
                                        }
                                        middlePageNumbers.forEach(function(pageNumber) {
                                            var paginationLink = document.createElement('li');
                                            paginationLink.classList.add('page-item');
                                            if (pageNumber === currentPage) {
                                                paginationLink.classList.add('active');
                                            }
                                            paginationLink.innerHTML =
                                                '<a class="page-link" href="javascript:void(0)" onclick="updatePage(event, ' + pageNumber +
                                                ')">' + pageNumber + '</a>';
                                            paginationList.appendChild(paginationLink);
                                        });
                                    } else {
                                        for (var i = start; i <= end; i++) {
                                            var paginationLink = document.createElement('li');
                                            paginationLink.classList.add('page-item');
                                            if (i === currentPage) {
                                                paginationLink.classList.add('active');
                                            }
                                            paginationLink.innerHTML =
                                                '<a class="page-link" href="javascript:void(0)" onclick="updatePage(event, ' + i + ')">' + i +
                                                '</a>';
                                            paginationList.appendChild(paginationLink);
                                        }
                                    }

                                    // add last page number
                                    if (pageNumber < totalPages - 1) {
                                        var paginationEllipsis = document.createElement('li');
                                        paginationEllipsis.classList.add('page-item');
                                        paginationEllipsis.classList.add('disabled');
                                        paginationEllipsis.innerHTML = '<a class="page-link" href="javascript:void(0)">...</a>';
                                        paginationList.appendChild(paginationEllipsis);
                                        var paginationLast = document.createElement('li');
                                        paginationLast.classList.add('page-item');
                                        if (totalPages === currentPage) {
                                            paginationLast.classList.add('active');
                                        }
                                        paginationLast.innerHTML = '<a class="page-link" href="javascript:void(0)" onclick="updatePage(event, ' +
                                            totalPages + ')">' + totalPages + '</a>';
                                        paginationList.appendChild(paginationLast);
                                    }

                                    // add next button
                                    var nextButton = document.createElement('li');
                                    nextButton.classList.add('page-item');
                                    nextButton.innerHTML = '<a class="page-link" aria-label="Next" onclick="updatePage(event, ' + (pageNumber + 1) +
                                        ')"><span aria-hidden="true">&raquo;</span></a>';
                                    if (pageNumber === totalPages) {
                                        nextButton.classList.add('disabled');
                                        nextButton.querySelector('a').removeAttribute('onclick');
                                    }
                                    paginationList.appendChild(nextButton);


                                    var paginationLinks = document.querySelectorAll('.pagination li');
                                    paginationLinks.forEach(function(link) {
                                        link.classList.remove('active');
                                        if (link.querySelector('a').innerHTML === currentPage.toString()) {
                                            link.classList.add('active');
                                        }
                                    });
                                }



                                window.onload = function() {
                                    updatePage(null, 1);

                                    var selectedCategory = localStorage.getItem('selectedCategory');
                                    var currentPage = localStorage.getItem('currentPage');
                                    if (selectedCategory) {
                                        updateSortByButton(selectedCategory);
                                        sortCards(selectedCategory);
                                    }
                                    if (currentPage) {
                                        var paginationList = document.querySelector('nav[aria-label="Page navigation example"] ul');
                                        if (paginationList === null) {
                                            console.error('paginationList is null');
                                            return;
                                        }

                                        var paginationLinks = paginationList.querySelectorAll('li');
                                        paginationLinks.forEach(function(link) {
                                            link.classList.remove('active');
                                        });
                                        var activeLink = paginationList.querySelector(
                                            'li:nth-child(2)'); // Select the second link (index 1 is the prev button)
                                        if (activeLink) {
                                            activeLink.classList.add('active');
                                        }
                                    } else {
                                        updatePage(null, 1);
                                    }
                                    document.querySelector('.dropdown-menu').addEventListener('click', function(event) {
                                        if (event.target.classList.contains('dropdown-item')) {
                                            var category = event.target.textContent.replace('Sort by ', '');
                                            if (category === 'All') {
                                                selectCategory('All');
                                            } else {
                                                selectCategory(category);
                                            }
                                        }
                                    });

                                    updatePagination(1);
                                }
                            </script>
                        </div>
                    </div>
                </section>
            </div>



            <!-- Sidebar Widgets -->
            <div class="sidebar-widgets order-1 order-sm-2 gap-1 flex-shrink-0 col-12 col-sm-12 col-md-3 col-lg-3">
                <!-- Sidebar Widget 1 -->
                <section class="side-widget d-block">
                    <div class="row px-0">
                        <div class="col-12 px-0">
                            <div class="card shadow-md">
                                <div class="card-header text-bg-primary">
                                    <h4 class="header-title m-0">Single button dropdowns</h4>
                                </div>
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn btn-light dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    Dropdown button
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div>
                    </div>
                </section>

                <!-- Sidebar Widget 2 -->
                <section class="side-widget d-none d-sm-none d-lg-block">
                    <div class="row px-0">
                        <div class="col-12 px-0">
                            <div class="card shadow-md">
                                <div class="card-header text-bg-primary">
                                    <h4 class="header-title m-0">Single button dropdowns</h4>
                                </div>
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn btn-light dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    Dropdown button
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div>
                    </div>
                </section>

                <!-- Sidebar Widget 3 -->
                <section class="side-widget d-none d-sm-none d-lg-block">
                    <div class="row px-0">
                        <div class="col-12 px-0">
                            <div class="card shadow-md">
                                <div class="card-header text-bg-primary">
                                    <h4 class="header-title m-0">Single button dropdowns</h4>
                                </div>
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <button class="btn btn-light dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    Dropdown button
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div>
                    </div>
                </section>
            </div>



        </section>
    </section>
@endsection





@section('footer_page_js')
@endsection
