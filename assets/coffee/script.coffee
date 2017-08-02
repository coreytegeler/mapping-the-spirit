$ ->
	$window = $(window)
	$body = $('body')
	$main = $('main')
	$header = $('header')
	$itemTitle = $header.find('.title.item')
	$grid = $('#grid')
	$aid = $('#aid')
	$frame = $('#frame')
	$pageTitle = $header.find('.pageTitle span')
	$secondary = $header.find('.secondary')
	$table = $('#table')
	$collection = $('#collection')
	$collectionItems = $collection.find('.items')
	transEnd = 'transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd'
	loadedSlug = $('.single:last-child').attr('data-slug')
	scrollInterval = null
	scrollShift = 0

	init = () ->
		noHover()
		dragAndDrop()
		loadCollection()
		$body.on 'mousewheel', '.horzScroll', (event) ->
			horzScroll(this, event)
		$body.scroll (event) ->
			vertScroll(this, event)
		$body.on 'mousemove', (e) ->
			$(this).find('.shift').each () ->
				shiftAndRotate(this, e)
		$body.on 'click', '#begin', begin
		$body.on 'click', '.button.collect', collectSingle
		$body.on 'click', '.button.close-single', closeSingle
		$body.on 'click', '.close-singles', putDownAll
		$body.on 'mousemove', '#collection', browseCollection
		$body.on 'click', '.item.click', clickItem
		$body.on 'mouseover', '.item.click', lookAt
		$body.on 'mouseleave', '.item.click', lookAway
		$body.on 'click', '.single.folder .handle', toggleFolder
		$body.on 'click', '.block.image:not(.noZoom) img', zoomImage
		$body.on 'click', '#frame .button', frameTool
		$body.on 'click', '.single .paginate', paginate
		$body.on 'click', '.single .block a.item', clickLink
		$body.on 'click', '.single .block .cite.show', showCite
		$body.on 'click', '#error a.back', goBack
		$body.on 'mouseover', '.row a', hoverRow
		$body.on 'mouseleave', '.row a', unhoverRow
		$body.on 'click', '.open-links', openLinks
		$(window).on 'popstate', browserNav
	  
		if $body.is('.looking')
			slug = $('.single').attr('data-slug')
			data = {action: 'up', slug: slug}
			history.replaceState(data, document.title, window.location.href)
			loadSingle($('.single'))

		if $grid
			buildGrid()
		loadImages($grid)
		checkSize()
		resizeFolder()

		$('.shift').each () ->
			shiftAndRotate(this)

		$body.addClass('loaded')

		$(window).resize () ->
			if checkSize('phone')
				$('.resizable').resizable('disable')
				$('.resizable').find('.text').each () ->
					$(this).attr('style', '')
			else
				$('.resizable').resizable('enable')
			resizeGrid()
			resizeFolder()
			resizeCollection()
			resizeFrameBar()
		.resize()

	buildGrid = () ->
		gutter = $grid.find('.gutter').innerWidth()
		# if checkSize('phone')
		# 	$body.addClass('mobile')
		# else
		$grid.isotope
			layoutMode: 'masonryHorizontal',
			itemSelector: '.item',
			percentPosition: false,
			gutter: gutter,
			transitionDuration: 0
			masonryHorizontal: {
				rowHeight: '.sizer',
				gutter: gutter,
				percentPosition: true,
				transitionDuration: 0
			},
			animationOptions: {
				duration: 0
			}
		$grid.addClass('loaded')
		resizeGrid()
		vertScroll()

	resizeGrid = () ->
		gutter = $grid.find('.gutter').innerWidth()
		if $grid.data('isotope')
			$grid.find('.item').each () ->
				sizeImage(this, gutter)
				$grid.isotope('layout')

	loadImages = (parent) ->
		if parent && parent.length
			$parent = $(parent)
		else
			$parent = $body
		$body.find('img.load').each (i, img) ->
			$img = $(img)
			$item = $($img.parents('.item')[0])
			$item.addClass('has-loader')
			src = $img.data('src')
			if !$item.find('.loader').length
				$item.append('<div class="loader"></div>')
			$img.attr('src', src)
			$.when(sizeImage($item)).done () ->
				if $item.parents('#grid')
					resizeGrid()
				$img.removeClass('load')
				$item.addClass('show')
				$item.imagesLoaded () ->
					$item.addClass('loaded')
					$img.css('width','')
					$img.css('height','')
					$img.css('maxHeight','')
					$item.css('width','')
					$item.css('height','')
					$item.css('maxHeight','')
					if $item.parents('#table').length
						if $grid.is('.loaded')
							resizeGrid()
						resizeCollection()

	sizeImage = (item, gutter) ->	
		$item = $(item)
		$img = $item.find('img')
		imgWidth = $img.data('width')
		imgHeight = $img.data('height')
		ratio = imgWidth/imgHeight
		if !ratio
			return
		# if image is in grid
		if(gutter)
			if($item.is('.large'))
				height = $table.innerHeight() - gutter*2
			else
				height = $table.innerHeight()/2 - gutter*1.5
			width = height*ratio
		# if image is in an item page
		else
			padding = parseInt($item.parents('.block').css('paddingLeft'))*2
			parentWidth = $item.parents('.inner').innerWidth() - padding
			maxWidth = parseInt($item.parents('.block').css('maxWidth'))
			if parentWidth > imgWidth
				width = imgWidth
			else
				width = parentWidth
			if width > maxWidth
				width = maxWidth
			height = width/ratio
		$item.css
			height: height
			maxHeight: height
		$img.css
			height: height
			maxHeight: height

		if(!$item.is('.show'))
			$item.css
				width: width
		else
			$img.width('')


	vertScroll = (self, event) ->
		vertScrollTop = $main.scrollTop()
		$section = $header.parents('section')
		if !$section.length
			return
		sectionTop = $section.offset().top
		if(sectionTop <= 0)
			$header.addClass('fixed')
			paddingTop = $header.innerHeight()
		else
			$header.removeClass('fixed')
			paddingTop = 0
		$section.css
			paddingTop: paddingTop

	horzScroll = (self, event) ->
		if $grid.length
			if $body.is('.mobile')
				return
			if event.deltaY != 0
				# event.preventDefault()
				self.scrollLeft -= event.deltaY
			if event.deltaX != 0
				return false

	dragAndDrop = () ->
		gutter = $grid.find('.gutter').innerWidth()
		$grid.find('.item').draggable
			containment: 'body',
			helper: 'clone',
			snap: '#collection',
			snapMode: 'inner',
			snapTolerance: 0,
			appendTo: 'body',
			scroll: false,
			cursorAt:
				left: 0,
				top: 0
			start: (event, ui) ->
				$helper = $(ui.helper)
				$helper.addClass('helper')
				$grid.addClass('dragging')
			drag: (event, ui) ->
				$helper = $(ui.helper)
				$helper.css
					'x': -$helper.innerWidth()/2,
					'y': -$helper.innerHeight()
				itemTop = ui.offset.top
				collectionTop = $collectionItems.offset().top
				if(itemTop >= collectionTop - 1)
					$helper.addClass('over')
				else
					$helper.removeClass('over')
			stop: (event, ui) ->
				$helper = $(ui.helper)
				$helper.removeClass('helper')
				$grid.removeClass('dragging')

		$collection.droppable
			accept: '.item.droppable',
			drop: (event, ui) ->
				$(this).removeClass('over')
				item = $(ui.draggable[0]).data('slug')
				collect(item, true)
			over: (event, ui) ->
				$collection.addClass('over')
			out: (event, ui) ->
				$collection.removeClass('over')

		$table.droppable
			accept: '.item',
			drop: (event, ui) ->
				$helper = ui.helper
				if $helper.is('.deletable')
					item = $helper.data('slug')
					uncollect(item)
			over: (event, ui) ->
				$helper = ui.helper
				$helper.addClass('deleting')
				$('#collection .placeholder').addClass('hide')
			out: (event, ui) ->
				$helper = ui.helper
				$helper.removeClass('deleting')
				$('#collection .placeholder').removeClass('hide')

		$collectionItems.sortable
			items: '> .item',
			containment: 'body',
			helper: 'clone',
			snap: '#collection .items',
			snapMode: 'inner',
			snapTolerance: 0,
			scroll: false,
			placeholder: 'placeholder',
			forcePlaceholderSize: true,
			start: (event, ui) ->
				$helper = $(ui.helper)
				$helper.addClass('deletable')
				$collection.addClass('sorting')
			stop: (event, ui) ->
				$collection.removeClass('sorting')
				storySlug = $(ui.helper).attr('data-story')
				saveCollection()


	collect = (slug, track) ->
		$item = $grid.find('[data-slug="'+slug+'"]').clone()
		$item.removeClass('shift rotate droppable')
		$item.addClass('collected')
		$item.attr('style', '')
		if($img = $item.find('img'))
			$img.attr('style', '')
			thumb = $item.attr('data-thumb')
			$img = $item.find('img')
			$img.attr('data-src', thumb)
			$img.attr('src', thumb)
		if $collection.find('[data-slug="'+slug+'"]').length
			return
		storySlug = $item.attr('data-story')
		if track
			ga 'send', 'event', 'item', 'collect', storySlug, slug
		$collection.removeClass('empty')
		$collectionItems.append($item)
		resizeCollection()
		saveCollection()
		resizeCollection()
		$item.imagesLoaded () ->
			setTimeout () ->
				resizeCollection()
			, 100
		if $body.is('.collection') && $item.is('.hide')
			$item = $grid.find('[data-slug="'+slug+'"]').removeClass('hide')
			$grid.isotope('layout')


	uncollect = (slug) ->
		$item = $collection.find('[data-slug="'+slug+'"]')
		story = $item.data('story')
		$item.remove()
		setTimeout () ->
			removeCollectedItem(story, slug)
			if(!$collection.find('.item').length)
				$collection.addClass('empty')
		,1
		if $body.is('.collection')
			$grid.find('[data-slug="'+slug+'"]').addClass('hide')
			$grid.isotope('layout')

	clickItem = (e) ->
		if !$grid.length
			return
		e.preventDefault()
		$item = $(this)
		if $item.is('.selected')
			slug = $item.attr('data-slug')
			$single = $('.single[data-slug="'+slug+'"]')
			if $single.is(':last-of-type')
				putDown(slug)
				return
			$single.addClass('swap')
			$main.append($single)
			setTimeout () ->
				$single.removeClass('swap')
			, 100
		else if $item.is('.collected') && $body.is('.looking')
			pickUp($item, true, true)
		else if !$body.is('.looking')
			pickUp($item, true, true)

	paginate = (e) ->
		e.preventDefault()
		$arrow = $(e.target)
		slug = $arrow.attr('data-slug')
		$item = $grid.find('.item[data-slug="'+slug+'"]')
		putDown(slug)
		if($item.length)
			pickUp($item, true, false)

	openDur = 600 # defined in single.scss
	closeDur = 300 # defined in single.scss
	pickUp = (item, push, over) ->
		$item = $(item)
		index = $item.attr('data-index')
		slug = $item.attr('data-slug')
		url = $item.attr('href')
		title = $item.attr('data-title')
		storySlug = $item.attr('data-story')
		$collection.find('.selected').removeClass('selected')
		$collected = $collection.find('[data-slug="'+slug+'"]')
		$collected.addClass('selected')
		$body.addClass('looking').addClass('waiting')
		$main.append('<div class="loader window"></div>')
		if tempUrl = url.split('.com')[1]
			ga('set', 'page', tempUrl)
			ga('send', 'pageview')
		setTimeout () ->
			$main.addClass('has-loader')
			createSingle(url, slug, push, over)

	createSingle = (url, slug, push, over) ->
		if push
			data = {action: 'up', slug: slug}
			history.pushState(data, document.title, url)
		$.ajax
			url: url,
			type: 'POST',
			data: {'request': true},
			dataType: 'html'
			error: (jqXHR, status, err) ->
				console.log(jqXHR, status, err)
			success: (html, status, jqXHR) ->
				$single = $('<div class="single"></div>')
				$main.append($single)
				$data = $($(html)[0])
				title = $data.data('title')
				slug = $data.data('slug')
				type = $data.data('type')
				url = $data.data('url')
				thumb = $data.data('thumb')
				$data.remove()
				$content = $($(html))
				$single
					.attr('data-title', title)
					.attr('data-slug', slug)
					.attr('data-type', type)
					.attr('data-url', url)
					.addClass(type)
				$single.html($content)
				if $body.is('.collection')
					replacePagination($single)
				$single.find('.rotate').each () ->
					shiftAndRotate(this)
				document.title = 'Mapping The Spirit — '+title
				$('meta[property="og:title"]').attr('content', 'Mapping The Spirit — '+title)
				$('meta[property="og:image"]').attr('content', thumb)
				$('meta[property="og:url"]').attr('content', url)
				$itemTitle.addClass('ready')
				$itemTitle.find('a').html(title)
				$itemTitle.find('a').attr('href', url)
				setTimeout () ->
					$itemTitle.addClass('show')
					loadSingle($single)
					$single.on transEnd, () ->
						$main.removeClass('has-loader')
						$single.prev('.loader').remove()
						$single.off(transEnd)
						$behind = $single.prev('.single:eq(0)')
						if($behind.length && !over)
							setTimeout () ->
								$behind.remove()
							500
					$single.addClass('open')
				, 300

	loadSingle = (single) ->
		makeResizable(single)
		$single = $(single)
		$single.addClass('loaded')
		slug = $single.attr('data-slug')
		story = $table.attr('data-story')
		$collectedItem = $collection.find('.item[data-slug="' + slug + '"]')
		if $collectedItem.length
			$collectedItem.addClass('selected')
			$single.find('.button.collect').removeClass('add').addClass('remove')
		$body.removeClass('waiting')
		loadImages(single)
		$single.on 'progress', (inst, image) ->
			$item = $(image.img).parents('.item')
			$item.addClass('loaded')
		$single.find('.block a').each () ->
			url = this.href
			search = '/stories/'+story+'/'
			if url.indexOf(search) <= -1
				$(this).attr('target', '_blank')
			else
				$(this).addClass('item')

	replacePagination = ($single) ->
		slug = $single.attr('data-slug')
		$item = $grid.find('.item[data-slug="'+slug+'"]')
		$prevArrow = $single.find('.paginate.prev')
		$nextArrow = $single.find('.paginate.next')
		$nextItem = $item.next('#grid .item')
		$prevItem = $item.prev('#grid .item')

		if $nextItem.length
			url = $nextItem.attr('data-url')
			slug = $nextItem.attr('data-slug')
			$nextArrow.attr('href', url).attr('data-slug', slug)
		else
			$nextArrow.remove()

		if $prevItem.length
			url = $prevItem.attr('data-url')
			slug = $prevItem.attr('data-slug')
			$prevArrow.attr('href', url).attr('data-slug', slug)
		else
			$prevArrow.remove()



	putDown = (slug, push) ->
		$single = $('.single[data-slug="' + slug + '"]')
		url = $table.data('url')
		if push
			data = {action: 'down', slug: slug}
			history.pushState(data, document.title, url)
		$collected = $('#collection .item[data-slug="'+slug+'"]').removeClass('selected')
		scrollLeft = $table.scrollLeft()
		$single.on transEnd, () ->
			$single.off(transEnd)
			$single.remove()
			if(!$('.single').length)
				$itemTitle.removeClass('ready')
				$body.removeClass('looking')
		$single.removeClass('open')

		$openSingles = $('.single.open')
		if(!$openSingles.length)
			$itemTitle.removeClass('show')
			document.title = 'Mapping The Spirit — ' + $main.data('title')
		else
			$newSingle = $($openSingles[$openSingles.length - 1])
			title = $newSingle.data('title')
			document.title = 'Mapping The Spirit — '+title
			$itemTitle.find('a').html()
			$itemTitle.find('a').attr('href', $newSingle.data('url'))

	putDownAll = (e) ->
		if($('.single').length)
			e.preventDefault()
		closeFrame()
		$('.single').each (i, single) ->
			setTimeout () ->
				slug = $(single).attr('data-slug')
				putDown(slug, true)
			, i*10

	resizeFolder = () ->
		$('.single.folder').each (i, single) ->
			$single = $(single)
			$leftSect = $single.find('section.left')
			$rightSect = $single.find('section.right')
			windowWidth = $window.innerWidth()
			leftWidth = $leftSect.innerWidth()
			rightWidth = windowWidth - leftWidth
			$rightSect.css({width:rightWidth})
			fontFactor = windowWidth*2*19
			$single.find('section').each (i, sect) ->
				$sect = $(sect)
				$inner = $sect.find('.inner')
				sectWidth = $sect.innerWidth()
				fontSize = sectWidth/windowWidth*2*19
				if(fontSize <= 25 && fontSize >= 9)
					$sect.find('.block').css({fontSize:fontSize+'px'})

	makeResizable = (single) ->
		$left = $(single).find('section.left')
		$(single).addClass('left')
		minWidth = $window.innerWidth()/5
		maxWidth = $window.innerWidth() - minWidth
		$left.resizable
			handles: 'e',
			minWidth: minWidth,
			maxWidth: maxWidth,
			create: (e, ui) ->
				$(e.target).addClass('resizable')
			resize: (e, ui) ->
				resizeFolder()
			start: (e, ui) ->
				$left.find('.video').addClass('noCursor')
			stop: (e, ui) ->
				$left.find('.video').removeClass('noCursor')

	toggleFolder = () ->
		$section = $(this)
		$single = $section.parents('.single')
		if !checkSize('phone')
			return
		if $single.is('.left')
			$single.removeClass('left').addClass('right')
		else if $single.is('.right')
			$single.removeClass('right').addClass('left')


	lookAt = () ->
		self = this
		if($grid.is('.dragging') || $collection.is('.sorting'))
			return
		slug = $(self).data('slug')
		$item = $('#grid .item[data-slug="'+slug+'"]')
		$collected = $('#collection .item[data-slug="'+slug+'"]')
		$collected.addClass('looking')
		$item.addClass('looking')

	lookAway = () ->
		self = this
		slug = $(self).data('slug')
		$item = $('#grid .item[data-slug="'+slug+'"]')
		$collected = $('#collection .item[data-slug="'+slug+'"]')
		$collected.removeClass('looking')
		$item.removeClass('looking')

	shiftAndRotate = (item, e) ->
		$item = $(item)
		if $item.is('.helper') || $item.parents('#collection').length
			return
		shift = $item.attr('data-shift')
		index = $item.attr('data-index')
		rotate = $item.attr('data-rotate')
		if shift == 0 || !shift
			shift = 0.5
		winWidth = $(window).innerWidth()
		winHeight = $(window).innerHeight()
		if e
			x = e.clientX
			y = e.clientY
		else
			x = winWidth/2
			y = winHeight/2
		shiftX =  -x / winWidth * shift
		shiftY =  -y / winHeight * shift
		if(!rotate)
			rotate = 0
		$item.css
			x: shiftX
			y: shiftY
			rotate3d: '0,0,1,' + rotate + 'deg'

	clickLink = (e) ->
		e.preventDefault()
		url = this.href
		parsed = url.split('/')
		slug = parsed[parsed.length-1]
		$item = $grid.find('.item[data-slug="'+slug+'"]')
		if $item
			pickUp($item, true, true)

	clipboard = new Clipboard('.cite.copy')
	clipboard.on 'success', (e) ->
		$link = $(e.trigger)
		$citation = $link.parents('.block').find('.citation')
		text = $link.html()
		$link.html('Citation copied')
		setTimeout () ->
			$link.html(text)
		, 1000

	showCite = (e) ->
		$block = $(this).parents('.block')
		$citation = $block.find('.citation')
		$citation.toggleClass('show')
		if $citation.is('.show')
			$(this).html('Hide citation')
		else
			$(this).html('Show citation')

	browserNav = (e) ->
		e.preventDefault()
		state = history.state
		if !$grid.length
			return
		if state
			action = state.action
			slug = state.slug
			if action == 'up'
				$item = $grid.find('.item[data-slug="'+slug+'"]')
				pickUp($item, false, false)
			else if action == 'down'
				putDown(slug, false, false)
		else
			putDownAll(e)

	closeSingle = (e) ->
		e.preventDefault()
		slug = $(e.target).parents('.single').attr('data-slug')
		putDown(slug, true)

	collectSingle = (e) ->
		$button = $(this)
		slug = $(e.target).parents('.single').attr('data-slug')
		if $button.is('.add')
			collect(slug, true)
			$collection.find('[data-slug="'+slug+'"]').addClass('selected')
			$button.removeClass('add')
			$button.addClass('remove')
		else
			$button.removeClass('remove')
			$button.addClass('add')
			uncollect(slug)

	loadCollection = () ->
		story = $table.data('story')
		collections = localStorage.getItem('mapping-the-spirit')
		if !collections
			return
		collections = JSON.parse(collections)
		if(story)
			collection = collections[story]
			insertCollection(collection, story)
		else
			$.each collections, (story, collection) ->
				insertCollection(collection, story)

	insertCollection = (collection, story) ->
		$.each collection, (i, slug) ->
			$item = $table.find('[data-slug="' + slug + '"]')
			if $item.length
				collect(slug, false)
			else
				createCollectionItem(slug, story, true)
				if $body.is('.collection')
					createCollectionItem(slug, story, false, i)

	createCollectionItem = (item, story, inFooter, index) ->
		url = '/api?item='+item+'&story='+story
		if index
			url += '&index='+index
		if inFooter
			url += '&footer='+inFooter
		$.ajax
			url: url
			dataType: 'html'
			error: (jqXHR, status, err) ->
				console.log(jqXHR, status, err)
			success: (item, status, jqXHR) ->
				if !item
					return
				addToCollection(item, story, inFooter)
		if($body.is('.aid'))
			$('.item[data-slug="'+item+'"]').addClass('collected')

	addToCollection = (item, story, inFooter) ->
		$item = $(item)
		if inFooter
			$('#collection .items').append($item)
			$collection.removeClass('empty')
		else
			if $item.is('.largeText')
				$item.removeClass('largeText').addClass('mediumText')
			$grid.append($item)
			$grid.isotope('appended', $item)
			$grid.isotope('layout')
		$item.imagesLoaded () ->
			if inFooter
				resizeCollection()
		loadImages()

	saveCollection = () ->
		$collectedItems = $collection.find('.item')
		collections = localStorage.getItem('mapping-the-spirit')
		if(collections)
			collections = JSON.parse(collections)
		else
			collections = {}
		cleared = []
		$collectedItems.each (i, item) ->
			slug = $(item).data('slug')
			story = $(item).attr('data-story')
			if $.inArray(story, cleared) < 0
				collections[story] = []
				cleared.push(story)
			if $.inArray(slug, collections[story]) < 0
				collections[story].push(slug)
		collections = JSON.stringify(collections)
		localStorage.setItem('mapping-the-spirit', collections)
		resizeCollection()

	removeCollectedItem = (story, item) ->
		collections = localStorage.getItem('mapping-the-spirit')
		if(collections)
			collections = JSON.parse(collections)
		else
			return
		index = $.inArray(item, collections[story])
		if index >= 0
			delete collections[story][index]
			collections = JSON.stringify(collections)
			localStorage.setItem('mapping-the-spirit', collections)

	browseCollection = (e) ->
		if $collection.is('.over') || $collection.is('.sorting')
			return
		mouse = e.clientX
		winWidth = $window.width()
		colWidth = $collectionItems.width()
		if winWidth > colWidth
			return
		mouse = event.pageX
		mouseShift = colWidth * ((winWidth/2 - mouse)/winWidth) * 1.1
		offset = $(window).width()/2
		x = -colWidth/2 + offset + mouseShift + mouse - winWidth/2
		if x > 0
			x = 0
		$collectionItems.css
			x: x + 'px'

	resizeCollection = () ->
		width = 0
		winWidth = $window.innerWidth()
		$collection.find('.item').each (i, item) ->
			width += $(item).outerWidth()
		if(width < winWidth)
			width += 10
		$collectionItems.css
			width: width
		if width < winWidth
			$collectionItems.css
				x: 0

	begin = () ->
		$body.animate
			scrollTop: $(window).innerHeight()+1
		, 800, 'easeInOutQuint'


	zoomImage = () ->
		$image = $(this)
		$block = $image.parents('.block')
		$text = $block.find('.text-wrap').clone()
		url = $image.attr('data-full')
		if !url
			url = $image.attr('src')
		$frame = $('<div id="frame" class="block image"><div id="frame-inner" class="has-loader"><div class="window loader"></div></div></div>')
		$buttons = $('<div class="buttons"><div class="button out"/><div class="button in"/><div class="button close"/></div>')
		$bar = $('<div id="frame-bar"><div class="button expand"/></div>')
		$frame.prepend($buttons)
		$bar.append($text)
		if !$text.find('.caption') || !$text.find('.caption').text().length
			$bar.addClass('noCaption')
		$body.append($frame).append($bar)
		setTimeout () ->
			$frame.addClass('show')
			$bar.addClass('show')
		img = new Image()
		img.src = url
		img.onload = () ->
			imgWidth = img.naturalWidth
			imgHeight = img.naturalHeight
			height = $frame.innerHeight()
			width = (height/imgHeight)*imgWidth
			window.frame = L.map 'frame-inner',
			  minZoom: 2,
			  maxZoom: 4,
			  zoom: 1,
			  center: [0, 0],
				zoomControl: false,
				crs: L.CRS.Simple
			southWest = frame.unproject([0, height], frame.getMaxZoom()-1)
			northEast = frame.unproject([width, 0], frame.getMaxZoom()-1)
			bounds = new L.LatLngBounds(southWest, northEast)
			L.imageOverlay(url, bounds).addTo(frame)
			frame.fitBounds(bounds)
			frame.setMaxBounds(bounds)
			setTimeout () ->
				$frame.addClass('loaded')

	frameTool = () ->
		if($(this).is('.out'))
			frame.zoomOut()
		else if($(this).is('.in'))
			frame.zoomIn()
		else if($(this).is('.close'))
			closeFrame()
		else if($(this).is('.expand'))
			$frameBar = $('#frame-bar')
			$frameBar.toggleClass('toggled')
			resizeFrameBar(this)

	closeFrame = () ->
		$frameBar = $('#frame-bar')
		$frame.on transEnd, () ->
			$frame.remove()
			$frameBar.remove()
			$frame.off(transEnd)
		$frame.removeClass('show')
		$frameBar.removeClass('show')

	resizeFrameBar = (button) ->
		$frameBar = $('#frame-bar')
		if $frameBar.is('.toggled')
			height = $frameBar.find('.text-wrap').innerHeight()
		else
			height = $frameBar.find('.meta').innerHeight()
		$frameBar.css
			height: height

	hoverRow = () ->
		$row = $(this).parents('.row')
		$row.addClass('hover')

	unhoverRow = () ->
		$row = $(this).parents('.row')
		$row.removeClass('hover')

	openLinks = () ->
		$header.toggleClass('toggled')
		
	goBack = (e) ->
		e.preventDefault()
		window.history.back()
			
	checkSize = (check) ->
		size = $body.css('content').replace(/\"/g, '')
		if !check
			return size
		else if size == check
			return true
		else
			return false

	noHover = () ->
		touch = 'ontouchstart' in document.documentElement || (navigator.MaxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0)
		if(!touch)
			return
	  try
			for si in document.styleSheets
				styleSheet = document.styleSheets[si]
				if styleSheet.rules
					break
				ri = styleSheet.rules.length - 1
				while ri >= 0
					if styleSheet.rules[ri].selectorText
						break
					if(styleSheet.rules[ri].selectorText.match(':hover'))
						styleSheet.deleteRule(ri)
					ri--
	init()