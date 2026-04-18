@extends('layouts.app')

@section('content')

{{-- Hero Section --}}
<div class="hero-section">
    <div class="hero-bg-image"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content container">
        <div class="hero-label">School Library System</div>
        <div class="hero-title">Li<span>Browse</span></div>
        <div class="hero-subtitle">Find, borrow, and return books — all in one place</div>

        {{-- Search Box --}}
        <form method="GET" action="/" id="search-form">
            <div class="search-wrapper">
                <button type="button" class="search-type-btn" onclick="toggleDropdown()">
                    <i class="bi bi-list-ul" style="font-size:14px;color:var(--accent)"></i>
                    <span id="search-type-label">Keyword</span>
                    <i class="bi bi-chevron-down" style="font-size:11px"></i>
                </button>
                <input type="hidden" name="type" id="search-type-value" value="keyword">
                <input
                    type="text"
                    name="search"
                    class="search-input-field"
                    placeholder="Type in the title, author or category..."
                    value="{{ request('search') }}"
                    autocomplete="off"
                >
                <button type="submit" class="search-submit">
                    <i class="bi bi-search me-1"></i> Search
                </button>
            </div>

            {{-- Dropdown --}}
            <div class="search-dropdown" id="search-dropdown">
                <div class="dropdown-opt active" onclick="setType('keyword', 'Keyword')">Keyword</div>
                <div class="dropdown-opt" onclick="setType('title', 'Title')">Title</div>
                <div class="dropdown-opt" onclick="setType('author', 'Author')">Author</div>
                <div class="dropdown-opt" onclick="setType('category', 'Category')">Category</div>
            </div>
        </form>

        {{-- Category Tags --}}
        <div class="d-flex gap-2 justify-content-center flex-wrap mt-2">
            @foreach($categories as $cat)
                <a href="/?search={{ $cat }}&type=category" class="cat-tag">{{ $cat }}</a>
            @endforeach
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="container mt-4">
    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="stat-card">
                <div class="stat-number">{{ \App\Models\Book::count() }}</div>
                <div class="stat-label">Total books</div>
            </div>
        </div>
        <div class="col-4">
            <div class="stat-card">
                <div class="stat-number">{{ \App\Models\Borrow::where('status', 'borrowed')->count() }}</div>
                <div class="stat-label">Currently borrowed</div>
            </div>
        </div>
        <div class="col-4">
            <div class="stat-card">
                <div class="stat-number">{{ $categories->count() }}</div>
                <div class="stat-label">Categories</div>
            </div>
        </div>
    </div>

    {{-- Book Grid --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="section-title mb-0">
            {{ request('search') ? 'Search results for "'.request('search').'"' : 'All books' }}
        </h5>
        <span class="text-muted-custom" style="font-size:13px">{{ $books->total() }} books found</span>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
        @forelse($books as $book)
        <div class="col">
            <div class="book-card h-100">
                {{-- Cover --}}
                <div style="height:120px; background:{{ ['#e8f0fe','#fce8e6','#e6f4ea','#fef7e0','#f3e8fd','#e8f5e9'][($book->id % 6)]}};
                    display:flex; align-items:center; justify-content:center; font-size:36px;">
                    {{ ['📘','📕','📗','📙','📓','📔'][$book->id % 6] }}
                </div>
                <div style="padding:12px 14px">
                    <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:2px;
                        white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $book->title }}">
                        {{ $book->title }}
                    </div>
                    <div style="font-size:12px;color:var(--text-muted);margin-bottom:6px">{{ $book->author }}</div>
                    <div style="margin-bottom:8px">
                        <span style="font-size:11px;background:var(--bg-secondary);color:var(--text-muted);
                            padding:2px 8px;border-radius:8px;">{{ $book->category }}</span>
                    </div>
                    @if($book->isAvailable())
                        <span class="badge-avail">Available ({{ $book->available_copies }})</span>
                    @else
                        <span class="badge-unavail">Not available</span>
                    @endif
                </div>
                <div style="padding:0 14px 14px; display:flex; gap:6px;">
                    <a href="/books/{{ $book->id }}"
                        style="flex:1;text-align:center;font-size:12px;padding:6px;border:1px solid var(--card-border);
                        border-radius:8px;color:var(--accent);text-decoration:none;background:transparent;"
                        onmouseover="this.style.background='var(--bg-secondary)'"
                        onmouseout="this.style.background='transparent'">
                        Details
                    </a>
                    @auth
                        @if($book->isBorrowedBy(auth()->id()))
                            <span style="flex:1;text-align:center;font-size:12px;padding:6px;border-radius:8px;
                                background:var(--bg-secondary);color:var(--text-muted);">Borrowed</span>
                        @elseif($book->isAvailable())
                            <form method="POST" action="/books/{{ $book->id }}/borrow" style="flex:1">
                                @csrf
                                <button type="submit"
                                    style="width:100%;font-size:12px;padding:6px;border:none;border-radius:8px;
                                    background:var(--accent);color:#fff;cursor:pointer;"
                                    onclick="return confirm('Borrow \'{{ addslashes($book->title) }}\'? Due in 7 days.')">
                                    Borrow
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="/login"
                            style="flex:1;text-align:center;font-size:12px;padding:6px;border-radius:8px;
                            background:var(--accent);color:#fff;text-decoration:none;">
                            Borrow
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        @empty
            <div class="col-12">
                <div style="text-align:center;padding:48px;color:var(--text-muted)">
                    <div style="font-size:40px;margin-bottom:12px">📭</div>
                    <div style="font-size:16px;font-weight:500">No books found</div>
                    <div style="font-size:13px;margin-top:4px">Try a different search term or category</div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $books->links() }}
    </div>
</div>

<script>
    function toggleDropdown() {
        document.getElementById('search-dropdown').classList.toggle('show');
    }

    function setType(value, label) {
        document.getElementById('search-type-value').value = value;
        document.getElementById('search-type-label').textContent = label;
        document.getElementById('search-dropdown').classList.remove('show');
        document.querySelectorAll('.dropdown-opt').forEach(el => el.classList.remove('active'));
        event.target.classList.add('active');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-type-btn') && !e.target.closest('#search-dropdown')) {
            document.getElementById('search-dropdown').classList.remove('show');
        }
    });
</script>
@endsection