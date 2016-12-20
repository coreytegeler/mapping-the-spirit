$ ->
	$window = $(window)
	$body = $('body')
	$main = $('main')
	$header = $('header')
	$itemTitle = $header.find('.title.item')
	$grid = $('.grid')
	$pageTitle = $header.find('.pageTitle span')
	$secondary = $header.find('.secondary')
	$table = $('#table')
	$single = $('#single')
	$collection = $('#collection')
	$collectionItems = $collection.find('.items')
	transEnd = 'transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd'
	loadedSlug = $single.attr('data-item')
	scrollInterval = null
	scrollShift = 0

	init = () ->
		dragAndDrop()
		loadCollection()
		doodle()
		$body.on 'mousewheel', '.horzScroll', (event) ->
			horzScroll(this, event)
		$body.scroll (event) ->
			vertScroll(this, event)
		$body.on 'click', '.closeSingle', (e) ->
			e.preventDefault()
			putDown(true)
		$body.on 'mousemove', (e) ->
			$(this).find('.shift').each () ->
				shiftAndRotate(this, e)
		$body.on 'mousemove', '#collection', browseCollection
		$(window).on 'popstate', (e) ->
			browserNav(e)
		$body.on 'click', '.item.click', (e) ->
			if $body.is('.story')
				e.preventDefault()
			$item = $(this)
			if $item.is('.selected')
				return
			else if $item.is('.collected') && $body.is('.looking') && !$body.is('.swapping')
				putDown()
				$body.addClass('swapping')
				setTimeout () ->
					pickUp($item, true)
				, 900
			else if !$body.is('.looking') && !$body.is('.swapping')
				pickUp($item, true)
		$body.on 'mouseover', '.item.click', () ->
			lookAt(this)
		$body.on 'mouseleave', '.item.click', () ->
			lookAway(this)
		$body.on 'click', '#single.folder section', (e) ->
			toggleFolder(this)
		  

		if($body.is('.looking'))
			if !history.state
				slug = $single.attr('data-item')
				data = {action: 'up', slug: slug}
				history.replaceState(data, document.title, window.location.href)
			loadSingle(loadedSlug)

		$grid.imagesLoaded () ->
			buildGrid()
			checkSize
			resizeFolder()
			resizeGrid()
			vertScroll()

		$('.shift').each () ->
			shiftAndRotate(this)

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
		.resize()

	buildGrid = () ->
		gutter = $grid.find('.gutter').innerWidth()
		if !checkSize('phone')
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
			# resizeGrid()
		$grid.addClass('loaded')

	resizeGrid = () ->
		buildGrid()
		if !checkSize('phone')
			gutter = $grid.find('.gutter').innerWidth()
			$grid.find('.item').each () ->
				$item = $(this)
				if($item.is('.large'))
					height = $table.innerHeight() - gutter*2
				else
					height = $table.innerHeight()/2 - gutter*1.5
				$item.css
					height: height
					maxHeight: height
				$item.find('img').css
					height: height
					maxHeight: height
			$grid.isotope()
			$grid.addClass('loaded')

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
		if checkSize('phone')
			return
		delta = event.deltaY
		if(delta != 0)
			event.preventDefault()
			self.scrollLeft -= delta

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
				$helper.css 'transform', ''
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
				$item = $(ui.draggable[0]).clone()
				addTo($item, true)
			over: (event, ui) ->
				$collection.addClass('over')
			out: (event, ui) ->
				$collection.removeClass('over')

		$table.droppable
			accept: '.item',
			drop: (event, ui) ->
				$helper = ui.helper
				if $helper.is('.deletable')
					$(ui.draggable).remove()
					setTimeout () ->
						if(!$collection.find('.item').length)
							$collection.addClass('empty')
					,1
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
			# axis: 'x',
			snap: '#collection .items',
			snapMode: 'inner',
			snapTolerance: 0,
			scroll: false,
			placeholder: 'placeholder',
			forcePlaceholderSize: true,
			cursorAt:
				left: 0,
				top: 0
			start: (event, ui) ->
				$helper = $(ui.helper)
				$helper.addClass('deletable')
				$collection.addClass('sorting')
			stop: (event, ui) ->
				$collection.removeClass('sorting')
				storySlug = $(ui.helper).attr('data-story')
				saveCollection(storySlug)


	addTo = (item) ->
		$item = $(item)
		$item.removeClass('shift rotate droppable')
		$item.addClass('collected')
		$item.attr('style', '')
		$item.find('img').attr('style', '')
		slug = $item.attr('data-slug')
		storySlug = $item.attr('data-story')
		if $collection.find('[data-slug="'+slug+'"]').length
			return
		$collection.removeClass('empty')
		$collectionItems.append($item)
		$item.imagesLoaded () ->
			resizeCollection()
		saveCollection(storySlug)


	openDur = 600
	closeDur = 300
	# defined in sass
	pickUp = (self, push) ->
		$item = $(self)
		index = $item.attr('data-index')
		type = $item.attr('data-type')
		slug = $item.attr('data-slug')
		url = $item.attr('href')
		title = $item.attr('data-title')
		storySlug = $item.attr('data-story')
		$collected = $('#collection .item[data-index="'+index+'"]')
		$collected.addClass('selected')
		$body.addClass('looking')
		$single.addClass('open')
		$itemTitle
			.addClass('ready')
			.find('a')
				.html(title)
				.attr('href', url)
		setTimeout () ->
			$itemTitle.addClass('show')
			$single.addClass('show')
		, 100
		setTimeout () ->
			$body.removeClass('swapping')
			$.ajax
				url: url
				dataType: 'html'
				error: (jqXHR, status, err) ->
					console.log(jqXHR)
					console.log(status)
					console.error(err)
				success: (response, status, jqXHR) ->
					if push
						data = {action: 'up', slug: slug}
						history.pushState(data, document.title, url)
					$single.addClass(type).attr('data-item', slug)
					if !$single.attr('data-slug')
						showCheck = setInterval () ->
							if($single.is('.show'))
								createSingle(response)
								clearInterval(showCheck)
						, 10
						$single.removeClass('loaded')
					else
						createSingle(response)
		, openDur

	createSingle = (html) ->
		$data = $($(html)[0])
		title = $data.data('title')
		slug = $data.data('item')
		type = $data.data('type')
		url = $data.data('url')
		$single
			.data('title', title)
			.data('slug', slug)
			.data('type', type)
			.data('url', url)			
		$single.off(transEnd)
		$single.html(html)
		setTimeout () ->
			loadSingle(slug)
		, 100

	loadSingle = (slug) ->
		makeResizable()
		if slug != $single.attr('data-item')
			return
		$single.addClass('loaded')
		$collection.find('.item[data-slug="' + slug + '"]').addClass('selected')
		setTimeout () ->
			imagesLoaded($single).on 'progress', (inst, image) ->
				$item = $(image.img).parents('.item')
				$item.addClass('loaded')
		, 500

	putDown = (push) ->
		itemSlug = $single.attr('data-item')
		url = window.location.href.replace(itemSlug, '')
		if push
			data = {action: 'down', slug: itemSlug}
			history.pushState(data, document.title, url);
		$collected = $('#collection .item.selected').removeClass('selected')
		scrollLeft = $table.scrollLeft()
		$single.on transEnd, () ->
			$single.off(transEnd)
			$single.removeClass('')
			$single.attr('class', '')
			$single.html('')
			$itemTitle.removeClass('ready')
			$body.removeClass('looking')
		$single.removeClass('show')
		$itemTitle.removeClass('show')

	resizeFolder = () ->
		$leftSect = $single.find('section#left')
		$rightSect = $single.find('section#right')
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

	makeResizable = () ->
		$left = $single.find('section#left')
		if $single.is('.folder')
			$single.addClass 'left'
		$left.resizable
			handles: 'e',
			create: (e, ui) ->
				$(e.target).addClass('resizable')
			resize: (e, ui) ->
				resizeFolder()

	toggleFolder = (section) ->
		if !checkSize('phone')
			return
		if $(section).is('#right')
			$single.addClass('right').removeClass('left')
		else
			$single.addClass('left').removeClass('right')


	lookAt = (self) ->
		if($grid.is('.dragging') || $collection.is('.sorting'))
			return
		slug = $(self).data('slug')
		$item = $('.grid .item[data-slug="'+slug+'"]')
		$collected = $('#collection .item[data-slug="'+slug+'"]')
		$collected.addClass('looking')
		$item.addClass('looking')

	lookAway = (self) ->
		slug = $(self).data('slug')
		$item = $('.grid .item[data-slug="'+slug+'"]')
		$collected = $('#collection .item[data-slug="'+slug+'"]')
		$collected.removeClass('looking')
		$item.removeClass('looking')

	shiftAndRotate = (item, e) ->
		$item = $(item)
		if $item.is('.helper')
			return
		shift = parseInt($item.attr('data-shift'))
		index = parseInt($item.attr('data-index'))
		rotate = parseInt($item.attr('data-rotate'))
		if shift == 0 || !shift
			shift = 0.5
		winWidth = $(window).innerWidth()
		winHeight = $(window).innerHeight()
		if e
			x = e.clientX
			y = e.clientY
		else
			x = 1
			y = 1
		shiftX =  -x / winWidth * shift
		shiftY =  -y / winHeight * shift
		if(!rotate)
			rotate = 0
		$item.css
			x: shiftX
			y: shiftY
			rotate3d: '0,0,1,' + rotate*.8 + 'deg'

	browserNav = (e) ->
		state = history.state
		if !state
			return
		action = state.action
		slug = state.slug
		if action == 'up'
			$item = $grid.find('.item[data-slug="'+slug+'"]')
			pickUp($item, false)
		else if action == 'down'
			putDown(false)

	loadCollection = () ->
		storySlug = $table.data('story')
		collections = localStorage.getItem('mapping-the-spirit')
		if !collections
			return
		collections = JSON.parse(collections)
		if(storySlug)
			collection = collections[storySlug]
			insertCollection(collection)
		else
			$.each collections, (storySlug, collection) ->
				insertCollection(collection, storySlug)

	insertCollection = (collection, story) ->
		$.each collection, (i, slug) ->
			$item = $table.find('[data-slug="' + slug + '"]')
			if $item.length
				addTo($item.clone(), false)
			else
				createCollectionItem(slug, story)

	createCollectionItem = (item, story) ->
		$collection.removeClass('empty');
		$.ajax
			url: '/api?item='+item+'&story='+story
			dataType: 'html'
			error: (jqXHR, status, err) ->
				console.log(jqXHR)
				console.log(status)
				console.error(err)
			success: (item, status, jqXHR) ->
				if !item
					return
				item = JSON.parse(item)
				$item = $('<a></a>')
				$item.addClass('click item collected')
				$item.addClass(item.type)
				$item.addClass(item.display)
				console.log item.content
				$item.attr('href', item.url)
				$item.attr('data-story', story)
				$item.attr('data-type', item.type)
				$item.attr('data-url', item.url)
				$item.attr('data-slug', item.slug)
				if item.display == 'text'
					$itemInner = $('<div class="inner"><div class="text">'+item.content+'</div></div>')
					$itemInner.css('color', item.color)
				else
					$itemInner = $('<div class="inner"><div class="image"><img src="'+item.content+'"/></div></div>')
					if(item.bw == 'true')
						$itemInner.find('.image').addClass('bw').css('background', item.color)
				$item.append($itemInner)
				$collectionItems.append($item)
				$item.imagesLoaded () ->
					resizeCollection()
				

	saveCollection = () ->
		newCollection = {}
		width = 0;
		$collection.find('.item').each (i, item) ->
			itemSlug = $(item).data('slug')
			storySlug = $(item).attr('data-story')
			width += $(item).outerWidth()
			if(!newCollection[storySlug])
				newCollection[storySlug] = []
			newCollection[storySlug].push(itemSlug)
		newCollection = JSON.stringify(newCollection)
		localStorage.setItem('mapping-the-spirit', newCollection)
		# resizeCollection()

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
		$collection.find('.item').each (i, item) ->
			width += $(item).outerWidth()
		$collectionItems.css
			width: width
		if width < $window.innerWidth()
			$collectionItems.css
				x: 0

	doodle = () ->
		return
		allMarks = []
		for i in [0...9]
			allMarks.push(i+1)
		$('.margin').each () ->
			$margin = $(this)
			marks = allMarks.slice(0, 2)
			marks.sort () ->
				return 0.5 - Math.random()
			width = $margin.innerWidth()
			height = $margin.innerHeight()
			count = 0
			for i in marks
				newImg = new Image
				newImg.src = '/assets/images/marks/'+i+'.png'
				$(newImg).on 'load', (e) ->
					img = e.target
					left = Math.random() * width
					heightPart = height/marks.length
					startTop = heightPart * count
					top = startTop + (Math.random() * heightPart)
					$(img).css
						left: left
						top: top
					$margin.append img
					count++
			
	checkSize = (check) ->
		size = $body.css('content').replace(/\"/g, '')
		if !check
			return size
		else if size == check
			return true
		else
			return false

	init()