(function(window, undefined) {
    var previousWishabi = window.wishabi;
    window.wishabi = {
        hostedservices: {
            iframe: {}
        },
        noConflict: function() {
            var wishabi = window.wishabi;
            window.wishabi = previousWishabi;
            console.log(wishabi);
            return wishabi
        }
    };
    wishabi.hostedservices.iframe.ShoppingListItem = function(itemId, name, description, prePriceText, priceText, postPriceText, validFrom, validTo, category, imageUrl, sku, custom1, custom2, custom3, custom4, custom5, custom6, disclaimerText, saleStory, locale, flyerTypeNameIdentifier, flyerRunId, numCouponsClipped, itemCoupons) {
        this.itemId = itemId;
        this.name = name;
        this.description = description;
        this.prePriceText = prePriceText;
        this.priceText = priceText;
        this.postPriceText = postPriceText;
        this.validFrom = validFrom;
        this.validTo = validTo;
        this.category = category;
        this.imageUrl = imageUrl;
        this.sku = sku;
        this.custom1 = custom1;
        this.custom2 = custom2;
        this.custom3 = custom3;
        this.custom4 = custom4;
        this.custom5 = custom5;
        this.custom6 = custom6;
        this.disclaimerText = disclaimerText;
        this.saleStory = saleStory;
        this.locale = locale;
        this.flyerTypeNameIdentifier = flyerTypeNameIdentifier;
        this.flyerRunId = flyerRunId;
        this.numCouponsClipped = numCouponsClipped;
        this.itemCoupons = itemCoupons
    };
    wishabi.hostedservices.iframe.ShoppingListDelegate = function() {};
    wishabi.hostedservices.iframe.ShoppingListDelegate.prototype.handleItemAddedClicked = function(shoppingList, itemId, item) {};
    wishabi.hostedservices.iframe.ShoppingListDelegate.prototype.handleItemRemovedClicked = function(shoppingList, itemId, item) {};
    wishabi.hostedservices.iframe.ShoppingListDelegate.prototype.handleShoppingListOpen = function(shoppingList) {};
    wishabi.hostedservices.iframe.ShoppingList = function(window, iframeWindow, delegate, iframeDomain) {
        this.window_ = window;
        this.iframeWindow_ = iframeWindow;
        this.delegate_ = delegate || new wishabi.hostedservices.iframe.ShoppingListDelegate;
        this.iframeDomain_ = iframeDomain || "*";
        var self = this;
        this.handleMessage_ = function(event) {
            if (event.source !== self.iframeWindow_ || event.origin !== self.iframeDomain_) return;
            try {
                var msg = self.window_.JSON.parse(event.data)
            } catch (error) {
                console.log("event data is not JSON format")
            }
            if (msg && msg.hasOwnProperty("type") && typeof msg.type === "string") {
                switch (msg["type"]) {
                    case "add_list_item":
                        self.delegate_.handleItemAddedClicked(self, msg["item_id"], new wishabi.hostedservices.iframe.ShoppingListItem(msg["item_id"], msg["name"], msg["description"], msg["pre_price_text"], msg["price_text"], msg["post_price_text"], msg["valid_from"], msg["valid_to"], msg["category"], msg["image_url"], msg["sku"], msg["custom1"], msg["custom2"], msg["custom3"], msg["custom4"], msg["custom5"], msg["custom6"], msg["disclaimer_text"], msg["sale_story"], msg["locale"], msg["flyer_type_name_identifier"], msg["flyer_run_id"], msg["num_coupons_clipped"], msg["coupons"]));
                        return;
                    case "remove_list_item":
                        self.delegate_.handleItemRemovedClicked(self, msg["item_id"], new wishabi.hostedservices.iframe.ShoppingListItem(msg["item_id"], msg["name"], msg["description"], msg["pre_price_text"], msg["price_text"], msg["post_price_text"], msg["valid_from"], msg["valid_to"], msg["category"], msg["image_url"], msg["sku"], msg["custom1"], msg["custom2"], msg["custom3"], msg["custom4"], msg["custom5"], msg["custom6"], msg["disclaimer_text"], msg["sale_story"], msg["locale"], msg["flyer_type_name_identifier"], msg["flyer_run_id"]));
                        return;
                    case "open_shopping_list":
                        self.delegate_.handleShoppingListOpen(self);
                        return
                }
            }
        };
        if (this.window_.addEventListener) this.window_.addEventListener("message", this.handleMessage_);
        else if (this.window_.attachEvent) this.window_.attachEvent("onmessage", this.handleMessage_)
    };
    wishabi.hostedservices.iframe.ShoppingList.prototype.dispose = function() {
        if (this.window_.removeEventListener) this.window_.removeEventListener("message", this.handleMessage_);
        else if (this.window_.detachEvent) this.window_.detachEvent("onmessage", this.handleMessage_);
        this.window_ = null;
        this.iframeWindow_ = null;
        this.delegate_ = null
    };
    wishabi.hostedservices.iframe.ShoppingList.prototype.addItem = function(itemId) {
        var msg = {
            type: "added_list_item",
            item_id: itemId
        };
        this.iframeWindow_.postMessage(this.window_.JSON.stringify(msg), this.iframeDomain_)
    };
    wishabi.hostedservices.iframe.ShoppingList.prototype.removeItem = function(itemId) {
        var msg = {
            type: "removed_list_item",
            item_id: itemId
        };
        this.iframeWindow_.postMessage(this.window_.JSON.stringify(msg), this.iframeDomain_)
    };
    wishabi.hostedservices.iframe.ShoppingList.prototype.setItems = function(itemIds) {
        var msg = {
            type: "set_list_items",
            item_ids: itemIds
        };
        this.iframeWindow_.postMessage(this.window_.JSON.stringify(msg), this.iframeDomain_)
    };
    wishabi.hostedservices.iframe.ShoppingList.customFields = {
        CUSTOM1: "custom1",
        CUSTOM2: "custom2",
        CUSTOM3: "custom3",
        CUSTOM4: "custom4",
        CUSTOM5: "custom5",
        CUSTOM6: "custom6",
        FLYER_ITEM_ID: "flyer_item_id",
        FLYER_ITEM_SKU: "flyer_item_sku"
    };
    wishabi.hostedservices.iframe.ShoppingCartDelegate = function() {};
    wishabi.hostedservices.iframe.ShoppingCartDelegate.prototype.handleItemAddedClicked = function(shoppingCart, itemId, item) {};
    wishabi.hostedservices.iframe.ShoppingCart = function(window, iframeWindow, delegate) {
        this.window_ = window;
        this.iframeWindow_ = iframeWindow;
        this.delegate_ = delegate || new wishabi.hostedservices.iframe.ShoppingCartDelegate;
        var self = this;
        this.handleMessage_ = function(event) {
            if (event.source !== self.iframeWindow_) return;
            try {
                var msg = self.window_.JSON.parse(event.data)
            } catch (error) {
                console.log("event data is not JSON format")
            }
            if (msg && msg.hasOwnProperty("type") && typeof msg.type === "string") {
                switch (msg["type"]) {
                    case "add_cart_item":
                        {
                            self.delegate_.handleItemAddedClicked(self, msg["item_id"], msg["payload"]);
                            return
                        }
                }
            }
        };
        if (this.window_.addEventListener) this.window_.addEventListener("message", this.handleMessage_);
        else if (this.window_.attachEvent) this.window_.attachEvent("onmessage", this.handleMessage_)
    };
    wishabi.hostedservices.iframe.ShoppingCart.prototype.dispose = function() {
        if (this.window_.removeEventListener) this.window_.removeEventListener("message", this.handleMessage_);
        else if (this.window_.detachEvent) this.window_.detachEvent("onmessage", this.handleMessage_);
        this.window_ = null;
        this.iframeWindow_ = null;
        this.delegate_ = null
    };
    wishabi.hostedservices.iframe.AnalyticsDelegate = function() {};
    wishabi.hostedservices.iframe.AnalyticsDelegate.prototype.handleAnalyticsEvent = function(analytics, detail) {};
    wishabi.hostedservices.iframe.Analytics = function(window, iframeWindow, delegate, iframeDomain) {
        this.window_ = window;
        this.iframeWindow_ = iframeWindow;
        this.delegate_ = delegate || new wishabi.hostedservices.iframe.AnalyticsDelegate;
        this.iframeDomain_ = iframeDomain || "*";
        var self = this;
        this.handleMessage_ = function(event) {
            if (event.source !== self.iframeWindow_ || event.origin !== self.iframeDomain_) return;
            try {
                var msg = self.window_.JSON.parse(event.data)
            } catch (error) {
                console.log("event data is not JSON format")
            }
            if (msg && msg.hasOwnProperty("type") && typeof msg.type === "string") {
                if (msg["type"] == "analytics") {
                    self.delegate_.handleAnalyticsEvent(self, msg)
                }
            }
        };
        if (this.window_.addEventListener) this.window_.addEventListener("message", this.handleMessage_);
        else if (this.window_.attachEvent) this.window_.attachEvent("onmessage", this.handleMessage_)
    };
    wishabi.hostedservices.iframe.Analytics.prototype.dispose = function() {
        if (this.window_.removeEventListener) this.window_.removeEventListener("message", this.handleMessage_);
        else if (this.window_.detachEvent) this.window_.detachEvent("onmessage", this.handleMessage_);
        this.window_ = null;
        this.iframeWindow_ = null
    };
    wishabi.hostedservices.iframe.Coupon = function(couponExternalId, flyerItemId, couponId, image, promotionText, saleStory, disclaimerText) {
        this.couponExternalId = couponExternalId;
        this.flyerItemId = flyerItemId;
        this.couponId = couponId;
        this.image = image;
        this.promotionText = promotionText;
        this.saleStory = saleStory;
        this.disclaimerText = disclaimerText
    };
    wishabi.hostedservices.iframe.LoyaltyCardDelegate = function() {};
    wishabi.hostedservices.iframe.LoyaltyCardDelegate.prototype.handleClipCoupon = function(loyaltyCard, coupon) {};
    wishabi.hostedservices.iframe.LoyaltyCardDelegate.prototype.handleUnclipCoupon = function(loyaltyCard, coupon) {};
    wishabi.hostedservices.iframe.LoyaltyCard = function(window, iframeWindow, delegate, iframeDomain) {
        this.window_ = window;
        this.iframeWindow_ = iframeWindow;
        this.delegate_ = delegate || new wishabi.hostedservices.iframe.LoyaltyCardDelegate;
        this.iframeDomain_ = iframeDomain || "*";
        var self = this;
        this.handleMessage_ = function(event) {
            if (event.source !== self.iframeWindow_ || event.origin !== self.iframeDomain_) return;
            try {
                var msg = self.window_.JSON.parse(event.data);
                var eventCoupon = msg.coupon
            } catch (error) {
                console.log("event data is not JSON format")
            }
            if (msg && msg.hasOwnProperty("type") && typeof msg.type === "string") {
                switch (msg["type"]) {
                    case "clip_coupon":
                        self.delegate_.handleClipCoupon(self, new wishabi.hostedservices.iframe.Coupon(eventCoupon["externalCouponId"], eventCoupon["flyerItemId"], eventCoupon["couponId"], eventCoupon["image"], eventCoupon["promotionText"], eventCoupon["saleStory"], eventCoupon["disclaimerText"]));
                        return;
                    case "unclip_coupon":
                        if (typeof self.delegate_.handleUnclipCoupon !== "undefined") {
                            self.delegate_.handleUnclipCoupon(self, new wishabi.hostedservices.iframe.Coupon(eventCoupon["externalCouponId"], eventCoupon["flyerItemId"], eventCoupon["couponId"], eventCoupon["image"], eventCoupon["promotionText"], eventCoupon["saleStory"], eventCoupon["disclaimerText"]))
                        }
                        return
                }
            }
        };
        if (this.window_.addEventListener) {
            this.window_.addEventListener("message", this.handleMessage_)
        } else if (this.window_.attachEvent) {
            this.window_.attachEvent("onmessage", this.handleMessage_)
        }
    };
    wishabi.hostedservices.iframe.LoyaltyCard.prototype.dispose = function() {
        if (this.window_.removeEventListener) {
            this.window_.removeEventListener("message", this.handleMessage_)
        } else if (this.window_.detachEvent) {
            this.window_.detachEvent("onmessage", this.handleMessage_)
        }
        this.window_ = null;
        this.iframeWindow_ = null;
        this.delegate_ = null
    };
    wishabi.hostedservices.iframe.LoyaltyCard.prototype.setCoupons = function(externalCouponIds) {
        var msg = {
            type: "set_coupons",
            coupons: externalCouponIds
        };
        this.iframeWindow_.postMessage(this.window_.JSON.stringify(msg), this.iframeDomain_)
    };
    wishabi.hostedservices.iframe.LoyaltyCard.prototype.couponClipped = function(externalCouponId) {
        var msg = {
            type: "coupon_clipped",
            coupons: [externalCouponId]
        };
        this.iframeWindow_.postMessage(this.window_.JSON.stringify(msg), this.iframeDomain_)
    };
    wishabi.hostedservices.iframe.LoyaltyCard.prototype.couponUnclipped = function(externalCouponId) {
        var msg = {
            type: "coupon_unclipped",
            coupons: [externalCouponId]
        };
        this.iframeWindow_.postMessage(this.window_.JSON.stringify(msg), this.iframeDomain_)
    };
    wishabi.hostedservices.iframe.LoyaltyCard.prototype.error = function(externalCouponId, errorMessage) {
        var msg = {
            type: "coupon_error",
            externalCouponId: externalCouponId,
            errorMessage: errorMessage
        };
        this.iframeWindow_.postMessage(this.window_.JSON.stringify(msg), this.iframeDomain_)
    };
    wishabi.hostedservices.iframe.Profile = function(uuid, loyaltyCardId, loyaltyCardPin, userId, opt_loggedIn) {
        this.uuid = uuid;
        this.userId = userId;
        this.loyaltyCardId = loyaltyCardId;
        this.loyaltyCardPin = loyaltyCardPin;
        if (opt_loggedIn !== false) {
            this.loggedIn = true
        } else {
            this.loggedIn = false
        }
    };
    wishabi.hostedservices.iframe.UserDelegate = function() {};
    wishabi.hostedservices.iframe.UserDelegate.prototype.handleSignIn = function(user) {};
    wishabi.hostedservices.iframe.UserDelegate.prototype.handleError = function(user, errorObject) {};
    wishabi.hostedservices.iframe.User = function(window, iframeWindow, delegate, iframeDomain) {
        this.window_ = window;
        this.iframeWindow_ = iframeWindow;
        this.delegate_ = delegate || new wishabi.hostedservices.iframe.UserDelegate;
        this.iframeDomain_ = iframeDomain || "*";
        var self = this;
        this.handleMessage_ = function(event) {
            if (event.source !== self.iframeWindow_ || event.origin !== self.iframeDomain_) return;
            try {
                var msg = self.window_.JSON.parse(event.data)
            } catch (error) {
                console.log("event data is not JSON format")
            }
            if (msg && msg.hasOwnProperty("type") && typeof msg.type === "string") {
                switch (msg["type"]) {
                    case "request_user_profile":
                        if (typeof self.delegate_.handleSignIn !== "undefined") {
                            self.delegate_.handleSignIn(self)
                        }
                        return;
                    case "error":
                        if (typeof self.delegate_.handleError !== "undefined") {
                            self.delegate_.handleError(self, msg)
                        }
                        return
                }
            }
        };
        if (this.window_.addEventListener) {
            this.window_.addEventListener("message", this.handleMessage_)
        } else if (this.window_.attachEvent) {
            this.window_.attachEvent("onmessage", this.handleMessage_)
        }
    };
    wishabi.hostedservices.iframe.User.prototype.dispose = function() {
        if (this.window_.removeEventListener) {
            this.window_.removeEventListener("message", this.handleMessage_)
        } else if (this.window_.detachEvent) {
            this.window_.detachEvent("onmessage", this.handleMessage_)
        }
        this.window_ = null;
        this.iframeWindow_ = null;
        this.delegate_ = null
    };
    wishabi.hostedservices.iframe.User.prototype.signIn = function(profile) {
        var msg = {
            type: "set_user_profile",
            uuid: profile.uuid,
            userId: profile.userId,
            loyalty_card_id: profile.loyaltyCardId,
            loyalty_card_pin: profile.loyaltyCardPin
        };
        this.iframeWindow_.postMessage(this.window_.JSON.stringify(msg), this.iframeDomain_)
    };
    wishabi.hostedservices.iframe.User.prototype.signOut = function() {
        var msg = {
            type: "unset_user_profile"
        };
        this.iframeWindow_.postMessage(this.window_.JSON.stringify(msg), this.iframeDomain_)
    };
    wishabi.hostedservices.iframe.ItemDetailsDelegate = function() {};
    wishabi.hostedservices.iframe.ItemDetailsDelegate.prototype.handleItemDetails = function(item) {};
    wishabi.hostedservices.iframe.ItemDetails = function(window, iframeWindow, delegate, iframeDomain) {
        this.window_ = window;
        this.iframeWindow_ = iframeWindow;
        this.delegate_ = delegate || new wishabi.hostedservices.iframe.ItemDetailsDelegate;
        this.iframeDomain_ = iframeDomain || "*";
        var self = this;
        this.handleMessage_ = function(event) {
            if (event.source !== self.iframeWindow_ || event.origin !== self.iframeDomain_) return;
            try {
                var msg = self.window_.JSON.parse(event.data)
            } catch (error) {
                console.log("event data is not JSON format")
            }
            if (msg && msg.hasOwnProperty("type") && typeof msg.type === "string") {
                switch (msg["type"]) {
                    case "item_details":
                        if (typeof self.delegate_.handleItemDetails !== "undefined") {
                            self.delegate_.handleItemDetails(msg["item"])
                        }
                        return;
                    case "iframe_handler_ready":
                        self.iframeWindow_.postMessage(self.window_.JSON.stringify({
                            type: "merchant_item_details"
                        }), self.iframeDomain_);
                        return
                }
            }
        };
        if (this.window_.addEventListener) {
            this.window_.addEventListener("message", this.handleMessage_)
        } else if (this.window_.attachEvent) {
            this.window_.attachEvent("onmessage", this.handleMessage_)
        }
    }
})(this);