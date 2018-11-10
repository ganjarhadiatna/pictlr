<div class="frame-box">
    <div class="top">
        <a href="{{ url('/box/'.$bx->idboxs) }}">
            @if ($bx->ttl_save != 0)
                <div class="pl-icn pl-image">
                    <div class="bg-image" style="background-image: url({{ asset('/story/thumbnails/'.$bx->cover1) }})"></div>
                    <div class="bg-image" style="background-image: url({{ asset('/story/thumbnails/'.$bx->cover2) }})"></div>
                    <div class="bg-image" style="background-image: url({{ asset('/story/thumbnails/'.$bx->cover3) }})"></div>
                </div>
            @else
                <div class="pl-icn">
                    <span class="mn-icn fas fa-lg fa-box-open"></span>
                </div>
            @endif
        </a>
    </div>
    <div class="bot">
        <a href="{{ url('/user/'.$bx->id) }}">
            <div class="image image-100px image-circle" style="background-image: url({{ asset('/profile/thumbnails/'.$bx->foto) }});"></div>
        </a>
    </div>
    <div class="mid">
        <a href="{{ url('/box/'.$bx->idboxs) }}">
            <h3 class="ctn-main-font ctn-min-color ctn-line">
                {{ $bx->title }}
            </h3>
        </a>
        <p class="ctn-main-font ctn-14px ctn-sek-color ctn-line ctn-thin">
            {{ $bx->description }}
        </p>
    </div>
    <div class="padding-bottom-15px"></div>
</div>