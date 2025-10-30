jQuery(function () {
    // Helpers
    const $q = (sel, ctx = document) => ctx.querySelector(sel);
    const $qa = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));

    // Utilities
    const util = {
        cleanSlug(value = "") {
            return value
                .toLowerCase()
                .replaceAll(/\W/gi, " ")
                .trim()
                .replaceAll(/\s{1,}/g, "-");
        }
    };

    // Init: Reset button
    function initResetButton() {
        const resetBtn = $q('button[data-type="reset"]');
        if (!resetBtn) return;
        resetBtn.addEventListener("click", () => {
            if (!confirm("This will reset all settings related to endpoints!")) return;
            const form = $q("#divi_map-customization-form");
            if (!form) return;
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "divi_map_reset";
            input.value = "1";
            form.appendChild(input);
            form.requestSubmit();
        });
    }

    // Stop initialization early if on settings tab
    initResetButton();
    if (location.href.includes("tab=settings")) return;

    // Init: Endpoints accordion + sortable
    function initEndpointsAccordion() {
        jQuery("#endpoints-ul")
            .accordion({ collapsible: true, active: false })
            .sortable({
                axis: "y",
                stop(e, ui) {
                    jQuery(this).accordion("refresh");
                }
            });
    }

    // Init: Role selects (select2)
    function initRoleSelects() {
        $qa('select[name$="[user_role][]"]').forEach((el) => {
            const $el = jQuery(el);
            $el.select2({
                multiple: true,
                placeholder: "Select roles",
                width: "180",
                data: mapdl_data.roles
            });
            $el.val($el.data("selected"));
            $el.trigger("change");
        });
    }

    // Endpoint overlay (add endpoint / link)
    function initEndpointOverlay() {
        const overlay = $q(".divi_map-enpoint-overlay");
        const endpointButton = $q('button[data-type="endpoint"]');
        if (!overlay || !endpointButton) return;

        const content = overlay.querySelector(".divi_map-dialog-content");
        const titleSpan = overlay.querySelector("span.title");
        const template = $q("#add-endpoint-template");

        function openOverlay(type, trigger) {
            overlay.classList.add("active");
            const replaceType = trigger?.dataset?.type || type;
            titleSpan.innerHTML = titleSpan.innerHTML.replace(/endpoint|link/, replaceType);
            content.innerHTML = (template ? template.innerHTML : "").replaceAll("%%flag%%", replaceType);
        }

        function closeOverlay() {
            overlay.classList.remove("active");
        }

        endpointButton.addEventListener("click", (ev) => openOverlay("endpoint", ev.target));

        // sanitize inputs on change
        overlay.addEventListener("change", (e) => {
            if (e.target && "value" in e.target) {
                e.target.value = e.target.value.trim().replace(/[\s]+/g, " ");
            }
        });

        // delegated click handling inside overlay
        overlay.addEventListener("click", (ev) => {
            const type = ev.target.dataset.type;
            if (!type) return;

            if (type === "close") {
                return closeOverlay();
            }

            if (type === "endpoint") {
                const input = overlay.querySelector("input");
                const errEl = overlay.querySelector("p.error");
                if (!input) return;
                const val = input.value.trim();
                if (!val) {
                    if (errEl) errEl.textContent = "The Label cannot be empty!";
                    return;
                }
                // validate label -> must contain alphabetic characters after cleaning
                const cleaned = util.cleanSlug(val);
                if (!cleaned) {
                    if (errEl) errEl.textContent = "Label must contain: Alphabetic characters!";
                    return;
                }
                closeOverlay();
                return;
            }

            if (type === "link") {
                // placeholder for link handling
                console.log("link");
            }
        });
    }

    // Icons picker
    function initIconsPicker() {
        const icons = mapdl_data.icons || {};
        const overlay = $q("#divi_map-icons-overlay");
        if (!overlay) return;

        const windowEl = overlay.querySelector("#divi_map-icons-window");
        const content = overlay.querySelector("#divi_map-icons-content");
        const search = overlay.querySelector("#divi_map-icons-search");
        const selectedPreview = windowEl.querySelector('span[data-type="selected-icon"]');

        let allItems = [];
        let items = allItems;
        let pageIndex = 0;
        let busy = false;
        let debounceTimer = 0;
        let currentTrigger = null;
        let currentSelected = null;
        let iconsInitialized = false;

        function setSelectedIcon(item) {
            if (!item) return;
            selectedPreview.innerHTML = item.textHtml;
            currentSelected = item;
        }

        function clearContent() {
            while (content.lastChild) content.lastChild.remove();
            content.scrollTo(0, 0);
            pageIndex = 0;
        }

        function loadMore(set = items) {
            busy = true;
            const start = 40 * pageIndex;
            const end = Math.min(start + 40, set.length);
            for (let i = start; i < end; i++) content.appendChild(set[i]);
            pageIndex++;
            busy = false;
        }

        function openIconsPicker(trigger) {
            if (!iconsInitialized) {
                for (const key in icons) {
                    const span = document.createElement("span");
                    span.title = key.replaceAll("-", " ");
                    span.key = key;
                    span.textHtml = icons[key];
                    span.insertAdjacentHTML("beforeend", span.textHtml);
                    span.onclick = () => setSelectedIcon(span);
                    allItems.push(span);
                }
                iconsInitialized = true;
            }
            overlay.classList.add("active");
            items = allItems;
            currentTrigger = trigger;
            clearContent();
            loadMore();
        }

        function closeIcons() {
            overlay.classList.remove("active");
            clearContent();
            search.value = "";
            selectedPreview.innerHTML = "";
            currentSelected = null;
            currentTrigger = null;
            items = allItems;
        }

        // listen to custom event to open
        document.addEventListener("icon:select", (ev) => openIconsPicker(ev.detail.trigger));

        content.onscroll = () => {
            if (!busy && content.scrollHeight < content.offsetHeight + content.scrollTop + 50) {
                loadMore(items);
            }
        };

        windowEl.onclick = (e) => {
            const type = e.target.dataset.type;
            if (!type) return;
            if (type === "icon") {
                const selectedEvent = new CustomEvent("icon:selected", {
                    detail: {
                        trigger: currentTrigger,
                        icon: currentSelected?.key || "",
                        html: currentSelected?.textHtml || ""
                    }
                });
                document.dispatchEvent(selectedEvent);
                closeIcons();
            } else if (type === "close") {
                closeIcons();
            }
        };

        windowEl.oninput = (e) => {
            clearTimeout(debounceTimer);
            const qVal = e.target.value?.trim();
            if (qVal) {
                debounceTimer = setTimeout(() => {
                    const q = qVal.toLowerCase();
                    items = allItems.filter((item) => item.title.toLowerCase().includes(q));
                    clearContent();
                    loadMore();
                }, 100);
            } else {
                items = allItems;
                clearContent();
                loadMore();
            }
        };
    }

    // Layouts picker
    function initLayoutsPicker() {
        const diviLayouts = mapdl_data.diviLayouts || [];
        const overlay = $q("#divi_map-layouts-overlay");
        if (!overlay) return;

        const windowEl = overlay.querySelector("#divi_map-layouts-window");
        const content = overlay.querySelector("#divi_map-layouts-content");
        const search = overlay.querySelector("#divi_map-layouts-search");

        let allItems = [];
        let items = allItems;
        let pageIndex = 0;
        let busy = false;
        let debounceTimer = 0;
        let currentTrigger = null;
        let currentSelected = null;
        let currentId = null;
        let layoutsInitialized = false;

        function setSelectedLayout(el) {
            if (!el) return;
            const prev = content.querySelector(".selected");
            if (prev) prev.className = "";
            el.className = "selected";
            currentSelected = el;
            currentId = el.dataset.id;
        }

        function clearContent() {
            while (content.lastChild) content.lastChild.remove();
            content.scrollTo(0, 0);
            pageIndex = 0;
        }

        function loadMore(set = items) {
            busy = true;
            const start = 40 * pageIndex;
            const end = Math.min(start + 40, set.length);
            for (let i = start; i < end; i++) {
                set[i].className = "";
                if (currentId && set[i].dataset.id === currentId) set[i].className = "selected";
                content.appendChild(set[i]);
            }
            pageIndex++;
            busy = false;
        }

        function openLayoutsPicker(trigger, current) {
            if (!layoutsInitialized) {
                for (const layout of diviLayouts) {
                    const h = document.createElement("h3");
                    h.dataset.title = layout.title;
                    h.dataset.id = layout.id;
                    h.innerText = layout.title;
                    h.onclick = () => setSelectedLayout(h);
                    allItems.push(h);
                }
                layoutsInitialized = true;
            }
            overlay.classList.add("active");
            currentTrigger = trigger;
            currentId = current;
            items = allItems;
            clearContent();
            loadMore();
        }

        document.addEventListener("layout:select", (ev) => openLayoutsPicker(ev.detail.trigger, ev.detail.current));

        content.onscroll = () => {
            if (!busy && content.scrollHeight < content.offsetHeight + content.scrollTop + 50) {
                loadMore(items);
            }
        };

        windowEl.onclick = (e) => {
            const type = e.target.dataset.type;
            if (!type) return;
            if (type === "layout") {
                if (currentSelected) {
                    const selectedEvent = new CustomEvent("layout:selected", {
                        detail: {
                            trigger: currentTrigger,
                            title: currentSelected.dataset.title || "",
                            id: currentSelected.dataset.id || ""
                        }
                    });
                    document.dispatchEvent(selectedEvent);
                }
                overlay.classList.remove("active");
                clearContent();
                search.value = "";
                currentSelected = null;
                currentId = null;
                currentTrigger = null;
                items = allItems;
            } else if (type === "close") {
                overlay.classList.remove("active");
                clearContent();
                search.value = "";
                currentSelected = null;
                currentId = null;
                currentTrigger = null;
                items = allItems;
            }
        };

        windowEl.oninput = (e) => {
            clearTimeout(debounceTimer);
            const qVal = e.target.value?.trim();
            if (qVal) {
                debounceTimer = setTimeout(() => {
                    const q = qVal.toLowerCase();
                    items = allItems.filter((el) => el.dataset.title.toLowerCase().includes(q));
                    clearContent();
                    loadMore();
                }, 100);
            } else {
                items = allItems;
                clearContent();
                loadMore();
            }
        };
    }

    // Global click / change handlers
    function initGlobalHandlers() {
        document.addEventListener("click", (e) => {
            const type = e.target.dataset?.type;
            if (type) {
                switch (type) {
                    case "icon-select":
                        document.dispatchEvent(new CustomEvent("icon:select", { detail: { trigger: e.target } }));
                        break;
                    case "icon-remove": {
                        const parent = e.target.parentElement;
                        if (!parent) break;
                        const preview = parent.querySelector(".divi_map-icon-preview");
                        const input = parent.querySelector("input");
                        if (preview) preview.innerHTML = "";
                        if (input) input.value = "";
                        break;
                    }
                    case "layout-select":
                        document.dispatchEvent(new CustomEvent("layout:select", {
                            detail: {
                                trigger: e.target,
                                current: e.target.parentElement.querySelector('input[name$="[id]"]').value
                            }
                        }));
                        break;
                    case "layout-remove": {
                        const parent = e.target.parentElement;
                        if (!parent) break;
                        const preview = parent.querySelector(".divi_map-layout-preview");
                        const titleInput = parent.querySelector('input[name$="[title]"]');
                        const idInput = parent.querySelector('input[name$="[id]"]');
                        if (preview) preview.innerHTML = "";
                        if (titleInput) titleInput.value = "";
                        if (idInput) idInput.value = "";
                        break;
                    }
                    case "endpoint-remove":
                        e.target.closest(".endpoints-li")?.remove();
                        break;
                }
            } else {
                // blur active text inputs when clicking elsewhere
                if (document.activeElement && document.activeElement.type === "text" && e.target.type !== "text") {
                    document.activeElement.blur();
                }
            }
        });

        document.addEventListener("change", (e) => {
            const el = e.target;
            if (!el?.name) return;

            if (el.name.endsWith("[label]")) {
                const val = el.value.trim();
                if (val) {
                    el.value = val;
                    const li = el.closest(".endpoints-li");
                    if (li) li.firstElementChild.lastChild.textContent = val;
                } else {
                    const li = el.closest(".endpoints-li");
                    if (li) el.value = li.firstElementChild.lastChild.textContent;
                }
            } else if (el.name.endsWith("[slug]")) {
                let cleaned = util.cleanSlug(el.value);
                if (cleaned) {
                    el.value = cleaned;
                } else {
                    const li = el.closest(".endpoints-li");
                    const fallback = li ? util.cleanSlug(li.firstElementChild.textContent) : "";
                    if (fallback) {
                        el.value = fallback;
                    } else {
                        el.value = "slug-" + Date.now();
                    }
                }
            }
        });

        document.addEventListener("icon:selected", (ev) => {
            const parent = ev.detail.trigger.parentElement;
            if (!parent) return;
            parent.querySelector(".divi_map-icon-preview").innerHTML = ev.detail.html;
            parent.querySelector("input").value = ev.detail.icon;
        });

        document.addEventListener("layout:selected", (ev) => {
            const parent = ev.detail.trigger.parentElement;
            if (!parent) return;
            parent.querySelector(".divi_map-layout-preview").innerHTML = ev.detail.title;
            parent.querySelector('input[name$="[title]"]').value = ev.detail.title;
            parent.querySelector('input[name$="[id]"]').value = ev.detail.id;
        });
    }

    // Initialize all pieces
    function init() {
        initEndpointsAccordion();
        initRoleSelects();
        initEndpointOverlay();
        initIconsPicker();
        initLayoutsPicker();
        initGlobalHandlers();
    }

    init();
});