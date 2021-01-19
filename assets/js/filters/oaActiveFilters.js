/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/js/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "XkVi");
/******/ })
/************************************************************************/
/******/ ({

/***/ "+/eK":
/***/ (function(module, exports) {

// a string of all valid unicode whitespaces
// eslint-disable-next-line max-len
module.exports = '\u0009\u000A\u000B\u000C\u000D\u0020\u00A0\u1680\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200A\u202F\u205F\u3000\u2028\u2029\uFEFF';


/***/ }),

/***/ "+N5y":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("n9AK");
var $map = __webpack_require__("zDWZ").map;
var arrayMethodHasSpeciesSupport = __webpack_require__("nB+7");
var arrayMethodUsesToLength = __webpack_require__("ocDp");

var HAS_SPECIES_SUPPORT = arrayMethodHasSpeciesSupport('map');
// FF49- issue
var USES_TO_LENGTH = arrayMethodUsesToLength('map');

// `Array.prototype.map` method
// https://tc39.github.io/ecma262/#sec-array.prototype.map
// with adding support of @@species
$({ target: 'Array', proto: true, forced: !HAS_SPECIES_SUPPORT || !USES_TO_LENGTH }, {
  map: function map(callbackfn /* , thisArg */) {
    return $map(this, callbackfn, arguments.length > 1 ? arguments[1] : undefined);
  }
});


/***/ }),

/***/ "+kY7":
/***/ (function(module, exports, __webpack_require__) {

var defineProperty = __webpack_require__("q9+l").f;
var has = __webpack_require__("8aeu");
var wellKnownSymbol = __webpack_require__("fVMg");

var TO_STRING_TAG = wellKnownSymbol('toStringTag');

module.exports = function (it, TAG, STATIC) {
  if (it && !has(it = STATIC ? it : it.prototype, TO_STRING_TAG)) {
    defineProperty(it, TO_STRING_TAG, { configurable: true, value: TAG });
  }
};


/***/ }),

/***/ "+oxZ":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("9JhN");
var DOMIterables = __webpack_require__("Ew2P");
var forEach = __webpack_require__("6OVi");
var createNonEnumerableProperty = __webpack_require__("WxKw");

for (var COLLECTION_NAME in DOMIterables) {
  var Collection = global[COLLECTION_NAME];
  var CollectionPrototype = Collection && Collection.prototype;
  // some Chrome versions have non-configurable methods on DOMTokenList
  if (CollectionPrototype && CollectionPrototype.forEach !== forEach) try {
    createNonEnumerableProperty(CollectionPrototype, 'forEach', forEach);
  } catch (error) {
    CollectionPrototype.forEach = forEach;
  }
}


/***/ }),

/***/ "+r8s":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.patternMatch` well-known symbol
// https://github.com/tc39/proposal-pattern-matching
defineWellKnownSymbol('patternMatch');


/***/ }),

/***/ "+tnu":
/***/ (function(module, exports, __webpack_require__) {

var _forEachInstanceProperty = __webpack_require__("i6Tr");

var cn = __webpack_require__("ycY6"),
    log = __webpack_require__("NOtv")('activeFilter dom'),
    params = {
  selectors: {
    itemsCanvas: 'ul'
  }
},
    templates = {
  main: __webpack_require__("99rr"),
  bsMain: __webpack_require__("SoW8"),
  item: __webpack_require__("utRA"),
  bsItem: __webpack_require__("1X0M")
},
    mainTemplate = templates.main,
    itemTemplate = templates.item;

module.exports = function (anchorElem) {
  var onRemove; // callback

  return {
    render: render,
    setOnRemove: setOnRemove,
    // set callback to call when remove request is set
    setMode: setMode
  };

  function render(data) {
    var wrapper = document.createElement('div'),
        itemsCanvas;

    _clear();

    if (!data.filters || !data.filters.length) {
      return;
    }

    wrapper.innerHTML = mainTemplate(data);
    itemsCanvas = cn.el(wrapper, params.selectors.itemsCanvas);

    _forEachInstanceProperty(cn).call(cn, data.filters, function (filter) {
      itemsCanvas.appendChild(_createFilterItem(filter));
    });

    anchorElem.appendChild(cn.childObject(wrapper, 0));
  }

  function setOnRemove(cb) {
    onRemove = cb;
  }

  function setMode(mode) {
    if (mode == 'bs') {
      mainTemplate = templates.bsMain;
      itemTemplate = templates.bsItem;
    }
  }

  function _createFilterItem(filter) {
    var itemWrapper = document.createElement('ul'),
        filterElem;
    itemWrapper.innerHTML = itemTemplate(filter);
    filterElem = cn.el(itemWrapper, 'li');
    cn.addEvent(cn.el(filterElem, 'a'), 'click', function (e) {
      log('click');
      cn.preventDefault(e);
      onRemove(filter); // handle this in widget
    });
    return filterElem;
  }

  function _clear() {
    var child;

    while (child = cn.childObject(anchorElem, 0)) {
      anchorElem.removeChild(child);
    }
  }
};

/***/ }),

/***/ "/HG3":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("iaIM");
var core = __webpack_require__("j0PW");

if (!core.JSON) core.JSON = { stringify: JSON.stringify };

// eslint-disable-next-line no-unused-vars
module.exports = function stringify(it, replacer, space) {
  return core.JSON.stringify.apply(null, arguments);
};


/***/ }),

/***/ "/L0j":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var getPrototypeOf = __webpack_require__("K1oV");
var createNonEnumerableProperty = __webpack_require__("jNzf");
var has = __webpack_require__("zNvU");
var wellKnownSymbol = __webpack_require__("HVcX");
var IS_PURE = __webpack_require__("Vl7J");

var ITERATOR = wellKnownSymbol('iterator');
var BUGGY_SAFARI_ITERATORS = false;

var returnThis = function () { return this; };

// `%IteratorPrototype%` object
// https://tc39.github.io/ecma262/#sec-%iteratorprototype%-object
var IteratorPrototype, PrototypeOfArrayIteratorPrototype, arrayIterator;

if ([].keys) {
  arrayIterator = [].keys();
  // Safari 8 has buggy iterators w/o `next`
  if (!('next' in arrayIterator)) BUGGY_SAFARI_ITERATORS = true;
  else {
    PrototypeOfArrayIteratorPrototype = getPrototypeOf(getPrototypeOf(arrayIterator));
    if (PrototypeOfArrayIteratorPrototype !== Object.prototype) IteratorPrototype = PrototypeOfArrayIteratorPrototype;
  }
}

if (IteratorPrototype == undefined) IteratorPrototype = {};

// 25.1.2.1.1 %IteratorPrototype%[@@iterator]()
if (!IS_PURE && !has(IteratorPrototype, ITERATOR)) {
  createNonEnumerableProperty(IteratorPrototype, ITERATOR, returnThis);
}

module.exports = {
  IteratorPrototype: IteratorPrototype,
  BUGGY_SAFARI_ITERATORS: BUGGY_SAFARI_ITERATORS
};


/***/ }),

/***/ "/q4V":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = {
  "january": {
    "en": "january",
    "fr": "janvier",
    "es": "enero",
    "de": "januar",
    "it": "gennaio",
    "br": "genver"
  },
  "february": {
    "en": "february",
    "fr": "février",
    "es": "febrero",
    "de": "februar",
    "it": "febbraio",
    "br": "c'hwevrer"
  },
  "march": {
    "en": "march",
    "fr": "mars",
    "es": "marzo",
    "de": "märz",
    "it": "marzo",
    "br": "meurzh"
  },
  "april": {
    "en": "april",
    "fr": "avril",
    "es": "abril",
    "de": "april",
    "it": "aprile",
    "br": "ebrel"
  },
  "may": {
    "en": "may",
    "fr": "mai",
    "es": "mayo",
    "de": "mai",
    "it": "maggio",
    "br": "mae"
  },
  "june": {
    "en": "june",
    "fr": "juin",
    "es": "junio",
    "de": "juni",
    "it": "giugno",
    "br": "mezheven"
  },
  "july": {
    "en": "july",
    "fr": "juillet",
    "es": "julio",
    "de": "juli",
    "it": "luglio",
    "br": "gouere"
  },
  "august": {
    "en": "august",
    "fr": "août",
    "es": "agosto",
    "de": "august",
    "it": "agosto",
    "br": "eost"
  },
  "september": {
    "en": "september",
    "fr": "septembre",
    "es": "septiembre",
    "de": "september",
    "it": "settembre",
    "br": "gwengolo"
  },
  "october": {
    "en": "october",
    "fr": "octobre",
    "es": "octubre",
    "de": "oktober",
    "it": "ottobre",
    "br": "here"
  },
  "november": {
    "en": "november",
    "fr": "novembre",
    "es": "noviembre",
    "de": "november",
    "it": "novembre",
    "br": "du"
  },
  "december": {
    "en": "december",
    "fr": "décembre",
    "es": "diciembre",
    "de": "dezember",
    "it": "dicembre",
    "br": "kerzu"
  },
  "monday": {
    "en": "monday",
    "fr": "lundi",
    "es": "lunes",
    "de": "montag",
    "it": "lunedì",
    "br": "lun"
  },
  "tuesday": {
    "en": "tuesday",
    "fr": "mardi",
    "es": "martes",
    "de": "dienstag",
    "it": "martedì",
    "br": "meurzh"
  },
  "wednesday": {
    "en": "wednesday",
    "fr": "mercredi",
    "es": "miércoles",
    "de": "mittwoch",
    "it": "mercoledì",
    "br": "merc'her"
  },
  "thursday": {
    "en": "thursday",
    "fr": "jeudi",
    "es": "jueves",
    "de": "donnerstag",
    "it": "giovedì",
    "br": "yaou"
  },
  "friday": {
    "en": "friday",
    "fr": "vendredi",
    "es": "viernes",
    "de": "freitag",
    "it": "venerdì",
    "br": "gwener"
  },
  "saturday": {
    "en": "saturday",
    "fr": "samedi",
    "es": "sábado",
    "de": "samstag",
    "it": "sabato",
    "br": "sadorn"
  },
  "sunday": {
    "en": "sunday",
    "fr": "dimanche",
    "es": "domingo",
    "de": "sonntag",
    "it": "domenica",
    "br": "sul"
  }
};

/***/ }),

/***/ "0/JC":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("oNh+");
var isObject = __webpack_require__("H3h0");

var document = global.document;
// typeof document.createElement is 'object' in old IE
var EXISTS = isObject(document) && isObject(document.createElement);

module.exports = function (it) {
  return EXISTS ? document.createElement(it) : {};
};


/***/ }),

/***/ "0FSu":
/***/ (function(module, exports, __webpack_require__) {

var bind = __webpack_require__("IRf+");
var IndexedObject = __webpack_require__("g6a+");
var toObject = __webpack_require__("N9G2");
var toLength = __webpack_require__("tJVe");
var arraySpeciesCreate = __webpack_require__("aoZ+");

var push = [].push;

// `Array.prototype.{ forEach, map, filter, some, every, find, findIndex }` methods implementation
var createMethod = function (TYPE) {
  var IS_MAP = TYPE == 1;
  var IS_FILTER = TYPE == 2;
  var IS_SOME = TYPE == 3;
  var IS_EVERY = TYPE == 4;
  var IS_FIND_INDEX = TYPE == 6;
  var NO_HOLES = TYPE == 5 || IS_FIND_INDEX;
  return function ($this, callbackfn, that, specificCreate) {
    var O = toObject($this);
    var self = IndexedObject(O);
    var boundFunction = bind(callbackfn, that, 3);
    var length = toLength(self.length);
    var index = 0;
    var create = specificCreate || arraySpeciesCreate;
    var target = IS_MAP ? create($this, length) : IS_FILTER ? create($this, 0) : undefined;
    var value, result;
    for (;length > index; index++) if (NO_HOLES || index in self) {
      value = self[index];
      result = boundFunction(value, index, O);
      if (TYPE) {
        if (IS_MAP) target[index] = result; // map
        else if (result) switch (TYPE) {
          case 3: return true;              // some
          case 5: return value;             // find
          case 6: return index;             // findIndex
          case 2: push.call(target, value); // filter
        } else if (IS_EVERY) return false;  // every
      }
    }
    return IS_FIND_INDEX ? -1 : IS_SOME || IS_EVERY ? IS_EVERY : target;
  };
};

module.exports = {
  // `Array.prototype.forEach` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.foreach
  forEach: createMethod(0),
  // `Array.prototype.map` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.map
  map: createMethod(1),
  // `Array.prototype.filter` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.filter
  filter: createMethod(2),
  // `Array.prototype.some` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.some
  some: createMethod(3),
  // `Array.prototype.every` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.every
  every: createMethod(4),
  // `Array.prototype.find` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.find
  find: createMethod(5),
  // `Array.prototype.findIndex` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.findIndex
  findIndex: createMethod(6)
};


/***/ }),

/***/ "0fQ6":
/***/ (function(module, exports, __webpack_require__) {

var has = __webpack_require__("zNvU");
var toIndexedObject = __webpack_require__("VcbD");
var indexOf = __webpack_require__("A551").indexOf;
var hiddenKeys = __webpack_require__("lyTg");

module.exports = function (object, names) {
  var O = toIndexedObject(object);
  var i = 0;
  var result = [];
  var key;
  for (key in O) !has(hiddenKeys, key) && has(O, key) && result.push(key);
  // Don't enum bug & hidden keys
  while (names.length > i) if (has(O, key = names[i++])) {
    ~indexOf(result, key) || result.push(key);
  }
  return result;
};


/***/ }),

/***/ "0foe":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var nativePropertyIsEnumerable = {}.propertyIsEnumerable;
var getOwnPropertyDescriptor = Object.getOwnPropertyDescriptor;

// Nashorn ~ JDK8 bug
var NASHORN_BUG = getOwnPropertyDescriptor && !nativePropertyIsEnumerable.call({ 1: 2 }, 1);

// `Object.prototype.propertyIsEnumerable` method implementation
// https://tc39.github.io/ecma262/#sec-object.prototype.propertyisenumerable
exports.f = NASHORN_BUG ? function propertyIsEnumerable(V) {
  var descriptor = getOwnPropertyDescriptor(this, V);
  return !!descriptor && descriptor.enumerable;
} : nativePropertyIsEnumerable;


/***/ }),

/***/ "0q0E":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("H3h0");
var isArray = __webpack_require__("ygwS");
var wellKnownSymbol = __webpack_require__("HVcX");

var SPECIES = wellKnownSymbol('species');

// `ArraySpeciesCreate` abstract operation
// https://tc39.github.io/ecma262/#sec-arrayspeciescreate
module.exports = function (originalArray, length) {
  var C;
  if (isArray(originalArray)) {
    C = originalArray.constructor;
    // cross-realm fallback
    if (typeof C == 'function' && (C === Array || isArray(C.prototype))) C = undefined;
    else if (isObject(C)) {
      C = C[SPECIES];
      if (C === null) C = undefined;
    }
  } return new (C === undefined ? Array : C)(length === 0 ? 0 : length);
};


/***/ }),

/***/ "0wSO":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("eOXo");

/***/ }),

/***/ "1A8d":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("JChK");

/***/ }),

/***/ "1FCb":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var toPrimitive = __webpack_require__("3Mt6");
var definePropertyModule = __webpack_require__("JliG");
var createPropertyDescriptor = __webpack_require__("96pp");

module.exports = function (object, key, value) {
  var propertyKey = toPrimitive(key);
  if (propertyKey in object) definePropertyModule.f(object, propertyKey, createPropertyDescriptor(0, value));
  else object[propertyKey] = value;
};


/***/ }),

/***/ "1Mu/":
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__("ct80");

// Thank's IE8 for his funny defineProperty
module.exports = !fails(function () {
  return Object.defineProperty({}, 1, { get: function () { return 7; } })[1] != 7;
});


/***/ }),

/***/ "1X0M":
/***/ (function(module, exports) {

module.exports = function anonymous(locals, escapeFn, include, rethrow) {
    rethrow = rethrow || function rethrow(err, str, flnm, lineno, esc) {
        var lines = str.split("\n");
        var start = Math.max(lineno - 3, 0);
        var end = Math.min(lines.length, lineno + 3);
        var filename = esc(flnm);
        var context = lines.slice(start, end).map(function(line, i) {
            var curr = i + start + 1;
            return (curr == lineno ? " >> " : "    ") + curr + "| " + line;
        }).join("\n");
        err.path = filename;
        err.message = (filename || "ejs") + ":" + lineno + "\n" + context + "\n\n" + err.message;
        throw err;
    };
    escapeFn = escapeFn || function(markup) {
        return markup == undefined ? "" : String(markup).replace(_MATCH_HTML, encode_char);
    };
    var _ENCODE_HTML_RULES = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&#34;",
        "'": "&#39;"
    }, _MATCH_HTML = /[&<>'"]/g;
    function encode_char(c) {
        return _ENCODE_HTML_RULES[c] || c;
    }
    var __line = 1, __lines = '<li class="active oa-filter-<%- type %>"><a href="#"><%= label %></a></li>', __filename = "widgets/activeFilters/bsItem.ejs";
    try {
        var __output = "";
        function __append(s) {
            if (s !== undefined && s !== null) __output += s;
        }
        with (locals || {}) {
            __append('<li class="active oa-filter-');
            __append(type);
            __append('"><a href="#">');
            __append(escapeFn(label));
            __append("</a></li>");
        }
        return __output;
    } catch (e) {
        rethrow(e, __lines, __filename, __line, escapeFn);
    }
}

/***/ }),

/***/ "1odi":
/***/ (function(module, exports) {

module.exports = {};


/***/ }),

/***/ "1t7P":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("ax0f");
var global = __webpack_require__("9JhN");
var getBuiltIn = __webpack_require__("VCi3");
var IS_PURE = __webpack_require__("DpO5");
var DESCRIPTORS = __webpack_require__("1Mu/");
var NATIVE_SYMBOL = __webpack_require__("56Cj");
var USE_SYMBOL_AS_UID = __webpack_require__("TbR9");
var fails = __webpack_require__("ct80");
var has = __webpack_require__("8aeu");
var isArray = __webpack_require__("xt6W");
var isObject = __webpack_require__("dSaG");
var anObject = __webpack_require__("FXyv");
var toObject = __webpack_require__("N9G2");
var toIndexedObject = __webpack_require__("N4z3");
var toPrimitive = __webpack_require__("CD8Q");
var createPropertyDescriptor = __webpack_require__("lhjL");
var nativeObjectCreate = __webpack_require__("guiJ");
var objectKeys = __webpack_require__("DEeE");
var getOwnPropertyNamesModule = __webpack_require__("ZdBB");
var getOwnPropertyNamesExternal = __webpack_require__("7lg/");
var getOwnPropertySymbolsModule = __webpack_require__("JAL5");
var getOwnPropertyDescriptorModule = __webpack_require__("GFpt");
var definePropertyModule = __webpack_require__("q9+l");
var propertyIsEnumerableModule = __webpack_require__("4Sk5");
var createNonEnumerableProperty = __webpack_require__("WxKw");
var redefine = __webpack_require__("uLp7");
var shared = __webpack_require__("TN3B");
var sharedKey = __webpack_require__("MyxS");
var hiddenKeys = __webpack_require__("1odi");
var uid = __webpack_require__("HYrn");
var wellKnownSymbol = __webpack_require__("fVMg");
var wrappedWellKnownSymbolModule = __webpack_require__("TkGI");
var defineWellKnownSymbol = __webpack_require__("aokA");
var setToStringTag = __webpack_require__("+kY7");
var InternalStateModule = __webpack_require__("zc29");
var $forEach = __webpack_require__("0FSu").forEach;

var HIDDEN = sharedKey('hidden');
var SYMBOL = 'Symbol';
var PROTOTYPE = 'prototype';
var TO_PRIMITIVE = wellKnownSymbol('toPrimitive');
var setInternalState = InternalStateModule.set;
var getInternalState = InternalStateModule.getterFor(SYMBOL);
var ObjectPrototype = Object[PROTOTYPE];
var $Symbol = global.Symbol;
var $stringify = getBuiltIn('JSON', 'stringify');
var nativeGetOwnPropertyDescriptor = getOwnPropertyDescriptorModule.f;
var nativeDefineProperty = definePropertyModule.f;
var nativeGetOwnPropertyNames = getOwnPropertyNamesExternal.f;
var nativePropertyIsEnumerable = propertyIsEnumerableModule.f;
var AllSymbols = shared('symbols');
var ObjectPrototypeSymbols = shared('op-symbols');
var StringToSymbolRegistry = shared('string-to-symbol-registry');
var SymbolToStringRegistry = shared('symbol-to-string-registry');
var WellKnownSymbolsStore = shared('wks');
var QObject = global.QObject;
// Don't use setters in Qt Script, https://github.com/zloirock/core-js/issues/173
var USE_SETTER = !QObject || !QObject[PROTOTYPE] || !QObject[PROTOTYPE].findChild;

// fallback for old Android, https://code.google.com/p/v8/issues/detail?id=687
var setSymbolDescriptor = DESCRIPTORS && fails(function () {
  return nativeObjectCreate(nativeDefineProperty({}, 'a', {
    get: function () { return nativeDefineProperty(this, 'a', { value: 7 }).a; }
  })).a != 7;
}) ? function (O, P, Attributes) {
  var ObjectPrototypeDescriptor = nativeGetOwnPropertyDescriptor(ObjectPrototype, P);
  if (ObjectPrototypeDescriptor) delete ObjectPrototype[P];
  nativeDefineProperty(O, P, Attributes);
  if (ObjectPrototypeDescriptor && O !== ObjectPrototype) {
    nativeDefineProperty(ObjectPrototype, P, ObjectPrototypeDescriptor);
  }
} : nativeDefineProperty;

var wrap = function (tag, description) {
  var symbol = AllSymbols[tag] = nativeObjectCreate($Symbol[PROTOTYPE]);
  setInternalState(symbol, {
    type: SYMBOL,
    tag: tag,
    description: description
  });
  if (!DESCRIPTORS) symbol.description = description;
  return symbol;
};

var isSymbol = USE_SYMBOL_AS_UID ? function (it) {
  return typeof it == 'symbol';
} : function (it) {
  return Object(it) instanceof $Symbol;
};

var $defineProperty = function defineProperty(O, P, Attributes) {
  if (O === ObjectPrototype) $defineProperty(ObjectPrototypeSymbols, P, Attributes);
  anObject(O);
  var key = toPrimitive(P, true);
  anObject(Attributes);
  if (has(AllSymbols, key)) {
    if (!Attributes.enumerable) {
      if (!has(O, HIDDEN)) nativeDefineProperty(O, HIDDEN, createPropertyDescriptor(1, {}));
      O[HIDDEN][key] = true;
    } else {
      if (has(O, HIDDEN) && O[HIDDEN][key]) O[HIDDEN][key] = false;
      Attributes = nativeObjectCreate(Attributes, { enumerable: createPropertyDescriptor(0, false) });
    } return setSymbolDescriptor(O, key, Attributes);
  } return nativeDefineProperty(O, key, Attributes);
};

var $defineProperties = function defineProperties(O, Properties) {
  anObject(O);
  var properties = toIndexedObject(Properties);
  var keys = objectKeys(properties).concat($getOwnPropertySymbols(properties));
  $forEach(keys, function (key) {
    if (!DESCRIPTORS || $propertyIsEnumerable.call(properties, key)) $defineProperty(O, key, properties[key]);
  });
  return O;
};

var $create = function create(O, Properties) {
  return Properties === undefined ? nativeObjectCreate(O) : $defineProperties(nativeObjectCreate(O), Properties);
};

var $propertyIsEnumerable = function propertyIsEnumerable(V) {
  var P = toPrimitive(V, true);
  var enumerable = nativePropertyIsEnumerable.call(this, P);
  if (this === ObjectPrototype && has(AllSymbols, P) && !has(ObjectPrototypeSymbols, P)) return false;
  return enumerable || !has(this, P) || !has(AllSymbols, P) || has(this, HIDDEN) && this[HIDDEN][P] ? enumerable : true;
};

var $getOwnPropertyDescriptor = function getOwnPropertyDescriptor(O, P) {
  var it = toIndexedObject(O);
  var key = toPrimitive(P, true);
  if (it === ObjectPrototype && has(AllSymbols, key) && !has(ObjectPrototypeSymbols, key)) return;
  var descriptor = nativeGetOwnPropertyDescriptor(it, key);
  if (descriptor && has(AllSymbols, key) && !(has(it, HIDDEN) && it[HIDDEN][key])) {
    descriptor.enumerable = true;
  }
  return descriptor;
};

var $getOwnPropertyNames = function getOwnPropertyNames(O) {
  var names = nativeGetOwnPropertyNames(toIndexedObject(O));
  var result = [];
  $forEach(names, function (key) {
    if (!has(AllSymbols, key) && !has(hiddenKeys, key)) result.push(key);
  });
  return result;
};

var $getOwnPropertySymbols = function getOwnPropertySymbols(O) {
  var IS_OBJECT_PROTOTYPE = O === ObjectPrototype;
  var names = nativeGetOwnPropertyNames(IS_OBJECT_PROTOTYPE ? ObjectPrototypeSymbols : toIndexedObject(O));
  var result = [];
  $forEach(names, function (key) {
    if (has(AllSymbols, key) && (!IS_OBJECT_PROTOTYPE || has(ObjectPrototype, key))) {
      result.push(AllSymbols[key]);
    }
  });
  return result;
};

// `Symbol` constructor
// https://tc39.github.io/ecma262/#sec-symbol-constructor
if (!NATIVE_SYMBOL) {
  $Symbol = function Symbol() {
    if (this instanceof $Symbol) throw TypeError('Symbol is not a constructor');
    var description = !arguments.length || arguments[0] === undefined ? undefined : String(arguments[0]);
    var tag = uid(description);
    var setter = function (value) {
      if (this === ObjectPrototype) setter.call(ObjectPrototypeSymbols, value);
      if (has(this, HIDDEN) && has(this[HIDDEN], tag)) this[HIDDEN][tag] = false;
      setSymbolDescriptor(this, tag, createPropertyDescriptor(1, value));
    };
    if (DESCRIPTORS && USE_SETTER) setSymbolDescriptor(ObjectPrototype, tag, { configurable: true, set: setter });
    return wrap(tag, description);
  };

  redefine($Symbol[PROTOTYPE], 'toString', function toString() {
    return getInternalState(this).tag;
  });

  redefine($Symbol, 'withoutSetter', function (description) {
    return wrap(uid(description), description);
  });

  propertyIsEnumerableModule.f = $propertyIsEnumerable;
  definePropertyModule.f = $defineProperty;
  getOwnPropertyDescriptorModule.f = $getOwnPropertyDescriptor;
  getOwnPropertyNamesModule.f = getOwnPropertyNamesExternal.f = $getOwnPropertyNames;
  getOwnPropertySymbolsModule.f = $getOwnPropertySymbols;

  wrappedWellKnownSymbolModule.f = function (name) {
    return wrap(wellKnownSymbol(name), name);
  };

  if (DESCRIPTORS) {
    // https://github.com/tc39/proposal-Symbol-description
    nativeDefineProperty($Symbol[PROTOTYPE], 'description', {
      configurable: true,
      get: function description() {
        return getInternalState(this).description;
      }
    });
    if (!IS_PURE) {
      redefine(ObjectPrototype, 'propertyIsEnumerable', $propertyIsEnumerable, { unsafe: true });
    }
  }
}

$({ global: true, wrap: true, forced: !NATIVE_SYMBOL, sham: !NATIVE_SYMBOL }, {
  Symbol: $Symbol
});

$forEach(objectKeys(WellKnownSymbolsStore), function (name) {
  defineWellKnownSymbol(name);
});

$({ target: SYMBOL, stat: true, forced: !NATIVE_SYMBOL }, {
  // `Symbol.for` method
  // https://tc39.github.io/ecma262/#sec-symbol.for
  'for': function (key) {
    var string = String(key);
    if (has(StringToSymbolRegistry, string)) return StringToSymbolRegistry[string];
    var symbol = $Symbol(string);
    StringToSymbolRegistry[string] = symbol;
    SymbolToStringRegistry[symbol] = string;
    return symbol;
  },
  // `Symbol.keyFor` method
  // https://tc39.github.io/ecma262/#sec-symbol.keyfor
  keyFor: function keyFor(sym) {
    if (!isSymbol(sym)) throw TypeError(sym + ' is not a symbol');
    if (has(SymbolToStringRegistry, sym)) return SymbolToStringRegistry[sym];
  },
  useSetter: function () { USE_SETTER = true; },
  useSimple: function () { USE_SETTER = false; }
});

$({ target: 'Object', stat: true, forced: !NATIVE_SYMBOL, sham: !DESCRIPTORS }, {
  // `Object.create` method
  // https://tc39.github.io/ecma262/#sec-object.create
  create: $create,
  // `Object.defineProperty` method
  // https://tc39.github.io/ecma262/#sec-object.defineproperty
  defineProperty: $defineProperty,
  // `Object.defineProperties` method
  // https://tc39.github.io/ecma262/#sec-object.defineproperties
  defineProperties: $defineProperties,
  // `Object.getOwnPropertyDescriptor` method
  // https://tc39.github.io/ecma262/#sec-object.getownpropertydescriptors
  getOwnPropertyDescriptor: $getOwnPropertyDescriptor
});

$({ target: 'Object', stat: true, forced: !NATIVE_SYMBOL }, {
  // `Object.getOwnPropertyNames` method
  // https://tc39.github.io/ecma262/#sec-object.getownpropertynames
  getOwnPropertyNames: $getOwnPropertyNames,
  // `Object.getOwnPropertySymbols` method
  // https://tc39.github.io/ecma262/#sec-object.getownpropertysymbols
  getOwnPropertySymbols: $getOwnPropertySymbols
});

// Chrome 38 and 39 `Object.getOwnPropertySymbols` fails on primitives
// https://bugs.chromium.org/p/v8/issues/detail?id=3443
$({ target: 'Object', stat: true, forced: fails(function () { getOwnPropertySymbolsModule.f(1); }) }, {
  getOwnPropertySymbols: function getOwnPropertySymbols(it) {
    return getOwnPropertySymbolsModule.f(toObject(it));
  }
});

// `JSON.stringify` method behavior with symbols
// https://tc39.github.io/ecma262/#sec-json.stringify
if ($stringify) {
  var FORCED_JSON_STRINGIFY = !NATIVE_SYMBOL || fails(function () {
    var symbol = $Symbol();
    // MS Edge converts symbol values to JSON as {}
    return $stringify([symbol]) != '[null]'
      // WebKit converts symbol values to JSON as null
      || $stringify({ a: symbol }) != '{}'
      // V8 throws on boxed symbols
      || $stringify(Object(symbol)) != '{}';
  });

  $({ target: 'JSON', stat: true, forced: FORCED_JSON_STRINGIFY }, {
    // eslint-disable-next-line no-unused-vars
    stringify: function stringify(it, replacer, space) {
      var args = [it];
      var index = 1;
      var $replacer;
      while (arguments.length > index) args.push(arguments[index++]);
      $replacer = replacer;
      if (!isObject(replacer) && it === undefined || isSymbol(it)) return; // IE8 returns string on undefined
      if (!isArray(replacer)) replacer = function (key, value) {
        if (typeof $replacer == 'function') value = $replacer.call(this, key, value);
        if (!isSymbol(value)) return value;
      };
      args[1] = replacer;
      return $stringify.apply(null, args);
    }
  });
}

// `Symbol.prototype[@@toPrimitive]` method
// https://tc39.github.io/ecma262/#sec-symbol.prototype-@@toprimitive
if (!$Symbol[PROTOTYPE][TO_PRIMITIVE]) {
  createNonEnumerableProperty($Symbol[PROTOTYPE], TO_PRIMITIVE, $Symbol[PROTOTYPE].valueOf);
}
// `Symbol.prototype[@@toStringTag]` property
// https://tc39.github.io/ecma262/#sec-symbol.prototype-@@tostringtag
setToStringTag($Symbol, SYMBOL);

hiddenKeys[HIDDEN] = true;


/***/ }),

/***/ "25Hm":
/***/ (function(module, exports, __webpack_require__) {

// TODO: remove from `core-js@4`
var defineWellKnownSymbol = __webpack_require__("tCEB");

defineWellKnownSymbol('replaceAll');


/***/ }),

/***/ "2K/m":
/***/ (function(module, exports, __webpack_require__) {

var requireObjectCoercible = __webpack_require__("j0cD");
var whitespaces = __webpack_require__("3sPw");

var whitespace = '[' + whitespaces + ']';
var ltrim = RegExp('^' + whitespace + whitespace + '*');
var rtrim = RegExp(whitespace + whitespace + '*$');

// `String.prototype.{ trim, trimStart, trimEnd, trimLeft, trimRight }` methods implementation
var createMethod = function (TYPE) {
  return function ($this) {
    var string = String(requireObjectCoercible($this));
    if (TYPE & 1) string = string.replace(ltrim, '');
    if (TYPE & 2) string = string.replace(rtrim, '');
    return string;
  };
};

module.exports = {
  // `String.prototype.{ trimLeft, trimStart }` methods
  // https://tc39.github.io/ecma262/#sec-string.prototype.trimstart
  start: createMethod(1),
  // `String.prototype.{ trimRight, trimEnd }` methods
  // https://tc39.github.io/ecma262/#sec-string.prototype.trimend
  end: createMethod(2),
  // `String.prototype.trim` method
  // https://tc39.github.io/ecma262/#sec-string.prototype.trim
  trim: createMethod(3)
};


/***/ }),

/***/ "2gZs":
/***/ (function(module, exports, __webpack_require__) {

var TO_STRING_TAG_SUPPORT = __webpack_require__("POz8");
var classofRaw = __webpack_require__("amH4");
var wellKnownSymbol = __webpack_require__("fVMg");

var TO_STRING_TAG = wellKnownSymbol('toStringTag');
// ES3 wrong here
var CORRECT_ARGUMENTS = classofRaw(function () { return arguments; }()) == 'Arguments';

// fallback for IE11 Script Access Denied error
var tryGet = function (it, key) {
  try {
    return it[key];
  } catch (error) { /* empty */ }
};

// getting tag from ES6+ `Object.prototype.toString`
module.exports = TO_STRING_TAG_SUPPORT ? classofRaw : function (it) {
  var O, tag, result;
  return it === undefined ? 'Undefined' : it === null ? 'Null'
    // @@toStringTag case
    : typeof (tag = tryGet(O = Object(it), TO_STRING_TAG)) == 'string' ? tag
    // builtinTag case
    : CORRECT_ARGUMENTS ? classofRaw(O)
    // ES3 arguments fallback
    : (result = classofRaw(O)) == 'Object' && typeof O.callee == 'function' ? 'Arguments' : result;
};


/***/ }),

/***/ "32/0":
/***/ (function(module, exports, __webpack_require__) {

var store = __webpack_require__("xgf2");

var functionToString = Function.toString;

// this helper broken in `3.4.1-3.4.4`, so we can't use `shared` helper
if (typeof store.inspectSource != 'function') {
  store.inspectSource = function (it) {
    return functionToString.call(it);
  };
}

module.exports = store.inspectSource;


/***/ }),

/***/ "32LZ":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.match` well-known symbol
// https://tc39.github.io/ecma262/#sec-symbol.match
defineWellKnownSymbol('match');


/***/ }),

/***/ "34wW":
/***/ (function(module, exports, __webpack_require__) {

var classof = __webpack_require__("amH4");
var regexpExec = __webpack_require__("QsUS");

// `RegExpExec` abstract operation
// https://tc39.github.io/ecma262/#sec-regexpexec
module.exports = function (R, S) {
  var exec = R.exec;
  if (typeof exec === 'function') {
    var result = exec.call(R, S);
    if (typeof result !== 'object') {
      throw TypeError('RegExp exec method returned something other than an Object or null');
    }
    return result;
  }

  if (classof(R) !== 'RegExp') {
    throw TypeError('RegExp#exec called on incompatible receiver');
  }

  return regexpExec.call(R, S);
};



/***/ }),

/***/ "3JDX":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

/**
 * This is the common logic for both the Node.js and web browser
 * implementations of `debug()`.
 */

__webpack_require__("6U7i");

__webpack_require__("iKE+");

__webpack_require__("KqXw");

__webpack_require__("DZ+c");

__webpack_require__("MvUL");

__webpack_require__("Ysgh");

var _indexOfInstanceProperty = __webpack_require__("0wSO");

var _spliceInstanceProperty = __webpack_require__("L0Na");

var _Object$keys = __webpack_require__("vGD7");

var _forEachInstanceProperty = __webpack_require__("i6Tr");

function setup(env) {
  var _context;

  createDebug.debug = createDebug;
  createDebug.default = createDebug;
  createDebug.coerce = coerce;
  createDebug.disable = disable;
  createDebug.enable = enable;
  createDebug.enabled = enabled;
  createDebug.humanize = __webpack_require__("a+Rm");

  _forEachInstanceProperty(_context = _Object$keys(env)).call(_context, function (key) {
    createDebug[key] = env[key];
  });
  /**
  * Active `debug` instances.
  */


  createDebug.instances = [];
  /**
  * The currently active debug mode names, and names to skip.
  */

  createDebug.names = [];
  createDebug.skips = [];
  /**
  * Map of special "%n" handling functions, for the debug "format" argument.
  *
  * Valid key names are a single, lower or upper-case letter, i.e. "n" and "N".
  */

  createDebug.formatters = {};
  /**
  * Selects a color for a debug namespace
  * @param {String} namespace The namespace string for the for the debug instance to be colored
  * @return {Number|String} An ANSI color code for the given namespace
  * @api private
  */

  function selectColor(namespace) {
    var hash = 0;

    for (var i = 0; i < namespace.length; i++) {
      hash = (hash << 5) - hash + namespace.charCodeAt(i);
      hash |= 0; // Convert to 32bit integer
    }

    return createDebug.colors[Math.abs(hash) % createDebug.colors.length];
  }

  createDebug.selectColor = selectColor;
  /**
  * Create a debugger with the given `namespace`.
  *
  * @param {String} namespace
  * @return {Function}
  * @api public
  */

  function createDebug(namespace) {
    var prevTime;

    function debug() {
      // Disabled?
      if (!debug.enabled) {
        return;
      }

      for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
        args[_key] = arguments[_key];
      }

      var self = debug; // Set `diff` timestamp

      var curr = Number(new Date());
      var ms = curr - (prevTime || curr);
      self.diff = ms;
      self.prev = prevTime;
      self.curr = curr;
      prevTime = curr;
      args[0] = createDebug.coerce(args[0]);

      if (typeof args[0] !== 'string') {
        // Anything else let's inspect with %O
        args.unshift('%O');
      } // Apply any `formatters` transformations


      var index = 0;
      args[0] = args[0].replace(/%([a-zA-Z%])/g, function (match, format) {
        // If we encounter an escaped % then don't increase the array index
        if (match === '%%') {
          return match;
        }

        index++;
        var formatter = createDebug.formatters[format];

        if (typeof formatter === 'function') {
          var val = args[index];
          match = formatter.call(self, val); // Now we need to remove `args[index]` since it's inlined in the `format`

          _spliceInstanceProperty(args).call(args, index, 1);

          index--;
        }

        return match;
      }); // Apply env-specific formatting (colors, etc.)

      createDebug.formatArgs.call(self, args);
      var logFn = self.log || createDebug.log;
      logFn.apply(self, args);
    }

    debug.namespace = namespace;
    debug.enabled = createDebug.enabled(namespace);
    debug.useColors = createDebug.useColors();
    debug.color = selectColor(namespace);
    debug.destroy = destroy;
    debug.extend = extend; // Debug.formatArgs = formatArgs;
    // debug.rawLog = rawLog;
    // env-specific initialization logic for debug instances

    if (typeof createDebug.init === 'function') {
      createDebug.init(debug);
    }

    createDebug.instances.push(debug);
    return debug;
  }

  function destroy() {
    var _context2;

    var index = _indexOfInstanceProperty(_context2 = createDebug.instances).call(_context2, this);

    if (index !== -1) {
      var _context3;

      _spliceInstanceProperty(_context3 = createDebug.instances).call(_context3, index, 1);

      return true;
    }

    return false;
  }

  function extend(namespace, delimiter) {
    return createDebug(this.namespace + (typeof delimiter === 'undefined' ? ':' : delimiter) + namespace);
  }
  /**
  * Enables a debug mode by namespaces. This can include modes
  * separated by a colon and wildcards.
  *
  * @param {String} namespaces
  * @api public
  */


  function enable(namespaces) {
    createDebug.save(namespaces);
    createDebug.names = [];
    createDebug.skips = [];
    var i;
    var split = (typeof namespaces === 'string' ? namespaces : '').split(/[\s,]+/);
    var len = split.length;

    for (i = 0; i < len; i++) {
      if (!split[i]) {
        // ignore empty strings
        continue;
      }

      namespaces = split[i].replace(/\*/g, '.*?');

      if (namespaces[0] === '-') {
        createDebug.skips.push(new RegExp('^' + namespaces.substr(1) + '$'));
      } else {
        createDebug.names.push(new RegExp('^' + namespaces + '$'));
      }
    }

    for (i = 0; i < createDebug.instances.length; i++) {
      var instance = createDebug.instances[i];
      instance.enabled = createDebug.enabled(instance.namespace);
    }
  }
  /**
  * Disable debug output.
  *
  * @api public
  */


  function disable() {
    createDebug.enable('');
  }
  /**
  * Returns true if the given mode name is enabled, false otherwise.
  *
  * @param {String} name
  * @return {Boolean}
  * @api public
  */


  function enabled(name) {
    if (name[name.length - 1] === '*') {
      return true;
    }

    var i;
    var len;

    for (i = 0, len = createDebug.skips.length; i < len; i++) {
      if (createDebug.skips[i].test(name)) {
        return false;
      }
    }

    for (i = 0, len = createDebug.names.length; i < len; i++) {
      if (createDebug.names[i].test(name)) {
        return true;
      }
    }

    return false;
  }
  /**
  * Coerce `val`.
  *
  * @param {Mixed} val
  * @return {Mixed}
  * @api private
  */


  function coerce(val) {
    if (val instanceof Error) {
      return val.stack || val.message;
    }

    return val;
  }

  createDebug.enable(createDebug.load());
  return createDebug;
}

module.exports = setup;

/***/ }),

/***/ "3Mt6":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("H3h0");

// `ToPrimitive` abstract operation
// https://tc39.github.io/ecma262/#sec-toprimitive
// instead of the ES6 spec version, we didn't implement @@toPrimitive case
// and the second argument - flag - preferred type is a string
module.exports = function (input, PREFERRED_STRING) {
  if (!isObject(input)) return input;
  var fn, val;
  if (PREFERRED_STRING && typeof (fn = input.toString) == 'function' && !isObject(val = fn.call(input))) return val;
  if (typeof (fn = input.valueOf) == 'function' && !isObject(val = fn.call(input))) return val;
  if (!PREFERRED_STRING && typeof (fn = input.toString) == 'function' && !isObject(val = fn.call(input))) return val;
  throw TypeError("Can't convert object to primitive value");
};


/***/ }),

/***/ "3sPw":
/***/ (function(module, exports) {

// a string of all valid unicode whitespaces
// eslint-disable-next-line max-len
module.exports = '\u0009\u000A\u000B\u000C\u000D\u0020\u00A0\u1680\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200A\u202F\u205F\u3000\u2028\u2029\uFEFF';


/***/ }),

/***/ "4/YM":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var charAt = __webpack_require__("t/tF").charAt;

// `AdvanceStringIndex` abstract operation
// https://tc39.github.io/ecma262/#sec-advancestringindex
module.exports = function (S, index, unicode) {
  return index + (unicode ? charAt(S, index).length : 1);
};


/***/ }),

/***/ "4Sk5":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var nativePropertyIsEnumerable = {}.propertyIsEnumerable;
var getOwnPropertyDescriptor = Object.getOwnPropertyDescriptor;

// Nashorn ~ JDK8 bug
var NASHORN_BUG = getOwnPropertyDescriptor && !nativePropertyIsEnumerable.call({ 1: 2 }, 1);

// `Object.prototype.propertyIsEnumerable` method implementation
// https://tc39.github.io/ecma262/#sec-object.prototype.propertyisenumerable
exports.f = NASHORN_BUG ? function propertyIsEnumerable(V) {
  var descriptor = getOwnPropertyDescriptor(this, V);
  return !!descriptor && descriptor.enumerable;
} : nativePropertyIsEnumerable;


/***/ }),

/***/ "56Cj":
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__("ct80");

module.exports = !!Object.getOwnPropertySymbols && !fails(function () {
  // Chrome 38 Symbol has incorrect toString conversion
  // eslint-disable-next-line no-undef
  return !String(Symbol());
});


/***/ }),

/***/ "58fF":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $forEach = __webpack_require__("zDWZ").forEach;
var arrayMethodIsStrict = __webpack_require__("nSCK");
var arrayMethodUsesToLength = __webpack_require__("ocDp");

var STRICT_METHOD = arrayMethodIsStrict('forEach');
var USES_TO_LENGTH = arrayMethodUsesToLength('forEach');

// `Array.prototype.forEach` method implementation
// https://tc39.github.io/ecma262/#sec-array.prototype.foreach
module.exports = (!STRICT_METHOD || !USES_TO_LENGTH) ? function forEach(callbackfn /* , thisArg */) {
  return $forEach(this, callbackfn, arguments.length > 1 ? arguments[1] : undefined);
} : [].forEach;


/***/ }),

/***/ "5Jdw":
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__("XU0c");

// Thank's IE8 for his funny defineProperty
module.exports = !fails(function () {
  return Object.defineProperty({}, 1, { get: function () { return 7; } })[1] != 7;
});


/***/ }),

/***/ "5TyG":
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__("XU0c");

module.exports = !!Object.getOwnPropertySymbols && !fails(function () {
  // Chrome 38 Symbol has incorrect toString conversion
  // eslint-disable-next-line no-undef
  return !String(Symbol());
});


/***/ }),

/***/ "5Uch":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("yHq5");

/***/ }),

/***/ "5ntg":
/***/ (function(module, exports) {

module.exports = function (it) {
  if (typeof it != 'function') {
    throw TypeError(String(it) + ' is not a function');
  } return it;
};


/***/ }),

/***/ "64g+":
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__("5Jdw");
var fails = __webpack_require__("XU0c");
var createElement = __webpack_require__("0/JC");

// Thank's IE8 for his funny defineProperty
module.exports = !DESCRIPTORS && !fails(function () {
  return Object.defineProperty(createElement('div'), 'a', {
    get: function () { return 7; }
  }).a != 7;
});


/***/ }),

/***/ "66wQ":
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__("ct80");

var replacement = /#|\.prototype\./;

var isForced = function (feature, detection) {
  var value = data[normalize(feature)];
  return value == POLYFILL ? true
    : value == NATIVE ? false
    : typeof detection == 'function' ? fails(detection)
    : !!detection;
};

var normalize = isForced.normalize = function (string) {
  return String(string).replace(replacement, '.').toLowerCase();
};

var data = isForced.data = {};
var NATIVE = isForced.NATIVE = 'N';
var POLYFILL = isForced.POLYFILL = 'P';

module.exports = isForced;


/***/ }),

/***/ "6OVi":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $forEach = __webpack_require__("0FSu").forEach;
var arrayMethodIsStrict = __webpack_require__("f4p7");
var arrayMethodUsesToLength = __webpack_require__("znGZ");

var STRICT_METHOD = arrayMethodIsStrict('forEach');
var USES_TO_LENGTH = arrayMethodUsesToLength('forEach');

// `Array.prototype.forEach` method implementation
// https://tc39.github.io/ecma262/#sec-array.prototype.foreach
module.exports = (!STRICT_METHOD || !USES_TO_LENGTH) ? function forEach(callbackfn /* , thisArg */) {
  return $forEach(this, callbackfn, arguments.length > 1 ? arguments[1] : undefined);
} : [].forEach;


/***/ }),

/***/ "6U7i":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var DESCRIPTORS = __webpack_require__("1Mu/");
var global = __webpack_require__("9JhN");
var isForced = __webpack_require__("66wQ");
var redefine = __webpack_require__("uLp7");
var has = __webpack_require__("8aeu");
var classof = __webpack_require__("amH4");
var inheritIfRequired = __webpack_require__("j6nH");
var toPrimitive = __webpack_require__("CD8Q");
var fails = __webpack_require__("ct80");
var create = __webpack_require__("guiJ");
var getOwnPropertyNames = __webpack_require__("ZdBB").f;
var getOwnPropertyDescriptor = __webpack_require__("GFpt").f;
var defineProperty = __webpack_require__("q9+l").f;
var trim = __webpack_require__("Ya2h").trim;

var NUMBER = 'Number';
var NativeNumber = global[NUMBER];
var NumberPrototype = NativeNumber.prototype;

// Opera ~12 has broken Object#toString
var BROKEN_CLASSOF = classof(create(NumberPrototype)) == NUMBER;

// `ToNumber` abstract operation
// https://tc39.github.io/ecma262/#sec-tonumber
var toNumber = function (argument) {
  var it = toPrimitive(argument, false);
  var first, third, radix, maxCode, digits, length, index, code;
  if (typeof it == 'string' && it.length > 2) {
    it = trim(it);
    first = it.charCodeAt(0);
    if (first === 43 || first === 45) {
      third = it.charCodeAt(2);
      if (third === 88 || third === 120) return NaN; // Number('+0x1') should be NaN, old V8 fix
    } else if (first === 48) {
      switch (it.charCodeAt(1)) {
        case 66: case 98: radix = 2; maxCode = 49; break; // fast equal of /^0b[01]+$/i
        case 79: case 111: radix = 8; maxCode = 55; break; // fast equal of /^0o[0-7]+$/i
        default: return +it;
      }
      digits = it.slice(2);
      length = digits.length;
      for (index = 0; index < length; index++) {
        code = digits.charCodeAt(index);
        // parseInt parses a string to a first unavailable symbol
        // but ToNumber should return NaN if a string contains unavailable symbols
        if (code < 48 || code > maxCode) return NaN;
      } return parseInt(digits, radix);
    }
  } return +it;
};

// `Number` constructor
// https://tc39.github.io/ecma262/#sec-number-constructor
if (isForced(NUMBER, !NativeNumber(' 0o1') || !NativeNumber('0b1') || NativeNumber('+0x1'))) {
  var NumberWrapper = function Number(value) {
    var it = arguments.length < 1 ? 0 : value;
    var dummy = this;
    return dummy instanceof NumberWrapper
      // check on 1..constructor(foo) case
      && (BROKEN_CLASSOF ? fails(function () { NumberPrototype.valueOf.call(dummy); }) : classof(dummy) != NUMBER)
        ? inheritIfRequired(new NativeNumber(toNumber(it)), dummy, NumberWrapper) : toNumber(it);
  };
  for (var keys = DESCRIPTORS ? getOwnPropertyNames(NativeNumber) : (
    // ES3:
    'MAX_VALUE,MIN_VALUE,NaN,NEGATIVE_INFINITY,POSITIVE_INFINITY,' +
    // ES2015 (in case, if modules with ES2015 Number statics required before):
    'EPSILON,isFinite,isInteger,isNaN,isSafeInteger,MAX_SAFE_INTEGER,' +
    'MIN_SAFE_INTEGER,parseFloat,parseInt,isInteger'
  ).split(','), j = 0, key; keys.length > j; j++) {
    if (has(NativeNumber, key = keys[j]) && !has(NumberWrapper, key)) {
      defineProperty(NumberWrapper, key, getOwnPropertyDescriptor(NativeNumber, key));
    }
  }
  NumberWrapper.prototype = NumberPrototype;
  NumberPrototype.constructor = NumberWrapper;
  redefine(global, NUMBER, NumberWrapper);
}


/***/ }),

/***/ "7lg/":
/***/ (function(module, exports, __webpack_require__) {

var toIndexedObject = __webpack_require__("N4z3");
var nativeGetOwnPropertyNames = __webpack_require__("ZdBB").f;

var toString = {}.toString;

var windowNames = typeof window == 'object' && window && Object.getOwnPropertyNames
  ? Object.getOwnPropertyNames(window) : [];

var getWindowNames = function (it) {
  try {
    return nativeGetOwnPropertyNames(it);
  } catch (error) {
    return windowNames.slice();
  }
};

// fallback for IE11 buggy Object.getOwnPropertyNames with iframe and window
module.exports.f = function getOwnPropertyNames(it) {
  return windowNames && toString.call(it) == '[object Window]'
    ? getWindowNames(it)
    : nativeGetOwnPropertyNames(toIndexedObject(it));
};


/***/ }),

/***/ "7x/C":
/***/ (function(module, exports, __webpack_require__) {

var TO_STRING_TAG_SUPPORT = __webpack_require__("POz8");
var redefine = __webpack_require__("uLp7");
var toString = __webpack_require__("UmhL");

// `Object.prototype.toString` method
// https://tc39.github.io/ecma262/#sec-object.prototype.tostring
if (!TO_STRING_TAG_SUPPORT) {
  redefine(Object.prototype, 'toString', toString, { unsafe: true });
}


/***/ }),

/***/ "7xRU":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("ax0f");
var IndexedObject = __webpack_require__("g6a+");
var toIndexedObject = __webpack_require__("N4z3");
var arrayMethodIsStrict = __webpack_require__("f4p7");

var nativeJoin = [].join;

var ES3_STRINGS = IndexedObject != Object;
var STRICT_METHOD = arrayMethodIsStrict('join', ',');

// `Array.prototype.join` method
// https://tc39.github.io/ecma262/#sec-array.prototype.join
$({ target: 'Array', proto: true, forced: ES3_STRINGS || !STRICT_METHOD }, {
  join: function join(separator) {
    return nativeJoin.call(toIndexedObject(this), separator === undefined ? ',' : separator);
  }
});


/***/ }),

/***/ "8+RD":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("dSaG");

module.exports = function (it) {
  if (!isObject(it) && it !== null) {
    throw TypeError("Can't set " + String(it) + ' as a prototype');
  } return it;
};


/***/ }),

/***/ "8EUF":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("kDpG");

module.exports = parent;


/***/ }),

/***/ "8G3K":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("eOXo");

/***/ }),

/***/ "8aeu":
/***/ (function(module, exports) {

var hasOwnProperty = {}.hasOwnProperty;

module.exports = function (it, key) {
  return hasOwnProperty.call(it, key);
};


/***/ }),

/***/ "8bDY":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("lv3h");
var DOMIterables = __webpack_require__("FszS");
var global = __webpack_require__("oNh+");
var classof = __webpack_require__("r/P8");
var createNonEnumerableProperty = __webpack_require__("jNzf");
var Iterators = __webpack_require__("m/wn");
var wellKnownSymbol = __webpack_require__("HVcX");

var TO_STRING_TAG = wellKnownSymbol('toStringTag');

for (var COLLECTION_NAME in DOMIterables) {
  var Collection = global[COLLECTION_NAME];
  var CollectionPrototype = Collection && Collection.prototype;
  if (CollectionPrototype && classof(CollectionPrototype) !== TO_STRING_TAG) {
    createNonEnumerableProperty(CollectionPrototype, TO_STRING_TAG, COLLECTION_NAME);
  }
  Iterators[COLLECTION_NAME] = Iterators.Array;
}


/***/ }),

/***/ "8msI":
/***/ (function(module, exports, __webpack_require__) {

var store = __webpack_require__("yULr");

var functionToString = Function.toString;

// this helper broken in `3.4.1-3.4.4`, so we can't use `shared` helper
if (typeof store.inspectSource != 'function') {
  store.inspectSource = function (it) {
    return functionToString.call(it);
  };
}

module.exports = store.inspectSource;


/***/ }),

/***/ "8qN7":
/***/ (function(module, exports, __webpack_require__) {

var toIndexedObject = __webpack_require__("VcbD");
var nativeGetOwnPropertyNames = __webpack_require__("x+gH").f;

var toString = {}.toString;

var windowNames = typeof window == 'object' && window && Object.getOwnPropertyNames
  ? Object.getOwnPropertyNames(window) : [];

var getWindowNames = function (it) {
  try {
    return nativeGetOwnPropertyNames(it);
  } catch (error) {
    return windowNames.slice();
  }
};

// fallback for IE11 buggy Object.getOwnPropertyNames with iframe and window
module.exports.f = function getOwnPropertyNames(it) {
  return windowNames && toString.call(it) == '[object Window]'
    ? getWindowNames(it)
    : nativeGetOwnPropertyNames(toIndexedObject(it));
};


/***/ }),

/***/ "8r/q":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("9JhN");
var isObject = __webpack_require__("dSaG");

var document = global.document;
// typeof document.createElement is 'object' in old IE
var EXISTS = isObject(document) && isObject(document.createElement);

module.exports = function (it) {
  return EXISTS ? document.createElement(it) : {};
};


/***/ }),

/***/ "8x0C":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("oNh+");
var createNonEnumerableProperty = __webpack_require__("jNzf");

module.exports = function (key, value) {
  try {
    createNonEnumerableProperty(global, key, value);
  } catch (error) {
    global[key] = value;
  } return value;
};


/***/ }),

/***/ "91A9":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var charAt = __webpack_require__("LTnH").charAt;
var InternalStateModule = __webpack_require__("WRdu");
var defineIterator = __webpack_require__("kYm/");

var STRING_ITERATOR = 'String Iterator';
var setInternalState = InternalStateModule.set;
var getInternalState = InternalStateModule.getterFor(STRING_ITERATOR);

// `String.prototype[@@iterator]` method
// https://tc39.github.io/ecma262/#sec-string.prototype-@@iterator
defineIterator(String, 'String', function (iterated) {
  setInternalState(this, {
    type: STRING_ITERATOR,
    string: String(iterated),
    index: 0
  });
// `%StringIteratorPrototype%.next` method
// https://tc39.github.io/ecma262/#sec-%stringiteratorprototype%.next
}, function next() {
  var state = getInternalState(this);
  var string = state.string;
  var index = state.index;
  var point;
  if (index >= string.length) return { value: undefined, done: true };
  point = charAt(string, index);
  state.index += point.length;
  return { value: point, done: false };
});


/***/ }),

/***/ "96pp":
/***/ (function(module, exports) {

module.exports = function (bitmap, value) {
  return {
    enumerable: !(bitmap & 1),
    configurable: !(bitmap & 2),
    writable: !(bitmap & 4),
    value: value
  };
};


/***/ }),

/***/ "99rr":
/***/ (function(module, exports) {

module.exports = function anonymous(locals, escapeFn, include, rethrow) {
    rethrow = rethrow || function rethrow(err, str, flnm, lineno, esc) {
        var lines = str.split("\n");
        var start = Math.max(lineno - 3, 0);
        var end = Math.min(lines.length, lineno + 3);
        var filename = esc(flnm);
        var context = lines.slice(start, end).map(function(line, i) {
            var curr = i + start + 1;
            return (curr == lineno ? " >> " : "    ") + curr + "| " + line;
        }).join("\n");
        err.path = filename;
        err.message = (filename || "ejs") + ":" + lineno + "\n" + context + "\n\n" + err.message;
        throw err;
    };
    escapeFn = escapeFn || function(markup) {
        return markup == undefined ? "" : String(markup).replace(_MATCH_HTML, encode_char);
    };
    var _ENCODE_HTML_RULES = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&#34;",
        "'": "&#39;"
    }, _MATCH_HTML = /[&<>'"]/g;
    function encode_char(c) {
        return _ENCODE_HTML_RULES[c] || c;
    }
    var __line = 1, __lines = '<% if ( filters.length ) { %>\n<ul class="active-filters" <% if ( !enabled ) { %>class="disabled"<% } %>></ul>\n<% } %>', __filename = "widgets/activeFilters/main.ejs";
    try {
        var __output = "";
        function __append(s) {
            if (s !== undefined && s !== null) __output += s;
        }
        with (locals || {}) {
            if (filters.length) {
                __append('\n<ul class="active-filters" ');
                __line = 2;
                if (!enabled) {
                    __append('class="disabled"');
                }
                __append("></ul>\n");
                __line = 3;
            }
        }
        return __output;
    } catch (e) {
        rethrow(e, __lines, __filename, __line, escapeFn);
    }
}

/***/ }),

/***/ "9JhN":
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {var check = function (it) {
  return it && it.Math == Math && it;
};

// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
module.exports =
  // eslint-disable-next-line no-undef
  check(typeof globalThis == 'object' && globalThis) ||
  check(typeof window == 'object' && window) ||
  check(typeof self == 'object' && self) ||
  check(typeof global == 'object' && global) ||
  // eslint-disable-next-line no-new-func
  Function('return this')();

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__("fRV1")))

/***/ }),

/***/ "9X0z":
/***/ (function(module, exports, __webpack_require__) {

var aFunction = __webpack_require__("5ntg");

// optional / simple context binding
module.exports = function (fn, that, length) {
  aFunction(fn);
  if (that === undefined) return fn;
  switch (length) {
    case 0: return function () {
      return fn.call(that);
    };
    case 1: return function (a) {
      return fn.call(that, a);
    };
    case 2: return function (a, b) {
      return fn.call(that, a, b);
    };
    case 3: return function (a, b, c) {
      return fn.call(that, a, b, c);
    };
  }
  return function (/* ...args */) {
    return fn.apply(that, arguments);
  };
};


/***/ }),

/***/ "9dYR":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("mxB3");

module.exports = parent;


/***/ }),

/***/ "9eyx":
/***/ (function(module, exports, __webpack_require__) {

var getBuiltIn = __webpack_require__("wF8L");

module.exports = getBuiltIn('navigator', 'userAgent') || '';


/***/ }),

/***/ "9hnf":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("n9AK");
var forEach = __webpack_require__("58fF");

// `Array.prototype.forEach` method
// https://tc39.github.io/ecma262/#sec-array.prototype.foreach
$({ target: 'Array', proto: true, forced: [].forEach != forEach }, {
  forEach: forEach
});


/***/ }),

/***/ "A4uS":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.observable` well-known symbol
// https://github.com/tc39/proposal-observable
defineWellKnownSymbol('observable');


/***/ }),

/***/ "A551":
/***/ (function(module, exports, __webpack_require__) {

var toIndexedObject = __webpack_require__("VcbD");
var toLength = __webpack_require__("Gpqx");
var toAbsoluteIndex = __webpack_require__("Nj2W");

// `Array.prototype.{ indexOf, includes }` methods implementation
var createMethod = function (IS_INCLUDES) {
  return function ($this, el, fromIndex) {
    var O = toIndexedObject($this);
    var length = toLength(O.length);
    var index = toAbsoluteIndex(fromIndex, length);
    var value;
    // Array#includes uses SameValueZero equality algorithm
    // eslint-disable-next-line no-self-compare
    if (IS_INCLUDES && el != el) while (length > index) {
      value = O[index++];
      // eslint-disable-next-line no-self-compare
      if (value != value) return true;
    // Array#indexOf ignores holes, Array#includes - not
    } else for (;length > index; index++) {
      if ((IS_INCLUDES || index in O) && O[index] === el) return IS_INCLUDES || index || 0;
    } return !IS_INCLUDES && -1;
  };
};

module.exports = {
  // `Array.prototype.includes` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.includes
  includes: createMethod(true),
  // `Array.prototype.indexOf` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.indexof
  indexOf: createMethod(false)
};


/***/ }),

/***/ "AP/O":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("ZMhG");

/***/ }),

/***/ "AYji":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("n9AK");
var $trim = __webpack_require__("2K/m").trim;
var forcedStringTrimMethod = __webpack_require__("eLIV");

// `String.prototype.trim` method
// https://tc39.github.io/ecma262/#sec-string.prototype.trim
$({ target: 'String', proto: true, forced: forcedStringTrimMethod('trim') }, {
  trim: function trim() {
    return $trim(this);
  }
});


/***/ }),

/***/ "B4Ad":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("YPef");

module.exports = parent;


/***/ }),

/***/ "B6F7":
/***/ (function(module, exports, __webpack_require__) {

var aFunction = __webpack_require__("5ntg");
var toObject = __webpack_require__("quhl");
var IndexedObject = __webpack_require__("fDXD");
var toLength = __webpack_require__("Gpqx");

// `Array.prototype.{ reduce, reduceRight }` methods implementation
var createMethod = function (IS_RIGHT) {
  return function (that, callbackfn, argumentsLength, memo) {
    aFunction(callbackfn);
    var O = toObject(that);
    var self = IndexedObject(O);
    var length = toLength(O.length);
    var index = IS_RIGHT ? length - 1 : 0;
    var i = IS_RIGHT ? -1 : 1;
    if (argumentsLength < 2) while (true) {
      if (index in self) {
        memo = self[index];
        index += i;
        break;
      }
      index += i;
      if (IS_RIGHT ? index < 0 : length <= index) {
        throw TypeError('Reduce of empty array with no initial value');
      }
    }
    for (;IS_RIGHT ? index >= 0 : length > index; index += i) if (index in self) {
      memo = callbackfn(memo, self[index], index, O);
    }
    return memo;
  };
};

module.exports = {
  // `Array.prototype.reduce` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.reduce
  left: createMethod(false),
  // `Array.prototype.reduceRight` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.reduceright
  right: createMethod(true)
};


/***/ }),

/***/ "By9b":
/***/ (function(module, exports, __webpack_require__) {

var anObject = __webpack_require__("LTNl");
var defineProperties = __webpack_require__("uK0S");
var enumBugKeys = __webpack_require__("yk1j");
var hiddenKeys = __webpack_require__("lyTg");
var html = __webpack_require__("R5XV");
var documentCreateElement = __webpack_require__("0/JC");
var sharedKey = __webpack_require__("iDMO");

var GT = '>';
var LT = '<';
var PROTOTYPE = 'prototype';
var SCRIPT = 'script';
var IE_PROTO = sharedKey('IE_PROTO');

var EmptyConstructor = function () { /* empty */ };

var scriptTag = function (content) {
  return LT + SCRIPT + GT + content + LT + '/' + SCRIPT + GT;
};

// Create object with fake `null` prototype: use ActiveX Object with cleared prototype
var NullProtoObjectViaActiveX = function (activeXDocument) {
  activeXDocument.write(scriptTag(''));
  activeXDocument.close();
  var temp = activeXDocument.parentWindow.Object;
  activeXDocument = null; // avoid memory leak
  return temp;
};

// Create object with fake `null` prototype: use iframe Object with cleared prototype
var NullProtoObjectViaIFrame = function () {
  // Thrash, waste and sodomy: IE GC bug
  var iframe = documentCreateElement('iframe');
  var JS = 'java' + SCRIPT + ':';
  var iframeDocument;
  iframe.style.display = 'none';
  html.appendChild(iframe);
  // https://github.com/zloirock/core-js/issues/475
  iframe.src = String(JS);
  iframeDocument = iframe.contentWindow.document;
  iframeDocument.open();
  iframeDocument.write(scriptTag('document.F=Object'));
  iframeDocument.close();
  return iframeDocument.F;
};

// Check for document.domain and active x support
// No need to use active x approach when document.domain is not set
// see https://github.com/es-shims/es5-shim/issues/150
// variation of https://github.com/kitcambridge/es5-shim/commit/4f738ac066346
// avoid IE GC bug
var activeXDocument;
var NullProtoObject = function () {
  try {
    /* global ActiveXObject */
    activeXDocument = document.domain && new ActiveXObject('htmlfile');
  } catch (error) { /* ignore */ }
  NullProtoObject = activeXDocument ? NullProtoObjectViaActiveX(activeXDocument) : NullProtoObjectViaIFrame();
  var length = enumBugKeys.length;
  while (length--) delete NullProtoObject[PROTOTYPE][enumBugKeys[length]];
  return NullProtoObject();
};

hiddenKeys[IE_PROTO] = true;

// `Object.create` method
// https://tc39.github.io/ecma262/#sec-object.create
module.exports = Object.create || function create(O, Properties) {
  var result;
  if (O !== null) {
    EmptyConstructor[PROTOTYPE] = anObject(O);
    result = new EmptyConstructor();
    EmptyConstructor[PROTOTYPE] = null;
    // add "__proto__" for Object.getPrototypeOf polyfill
    result[IE_PROTO] = O;
  } else result = NullProtoObject();
  return Properties === undefined ? result : defineProperties(result, Properties);
};


/***/ }),

/***/ "C0uO":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("8bDY");
var forEach = __webpack_require__("8EUF");
var classof = __webpack_require__("r/P8");
var ArrayPrototype = Array.prototype;

var DOMIterables = {
  DOMTokenList: true,
  NodeList: true
};

module.exports = function (it) {
  var own = it.forEach;
  return it === ArrayPrototype || (it instanceof Array && own === ArrayPrototype.forEach)
    // eslint-disable-next-line no-prototype-builtins
    || DOMIterables.hasOwnProperty(classof(it)) ? forEach : own;
};


/***/ }),

/***/ "C36Y":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

// EXPORTS
__webpack_require__.d(__webpack_exports__, "PART_TYPE", function() { return /* reexport */ PART_TYPE; });
__webpack_require__.d(__webpack_exports__, "isFormatXMLElementFn", function() { return /* reexport */ isFormatXMLElementFn; });
__webpack_require__.d(__webpack_exports__, "formatToParts", function() { return /* reexport */ formatToParts; });
__webpack_require__.d(__webpack_exports__, "createDefaultFormatters", function() { return /* reexport */ createDefaultFormatters; });
__webpack_require__.d(__webpack_exports__, "IntlMessageFormat", function() { return /* reexport */ core_IntlMessageFormat; });
__webpack_require__.d(__webpack_exports__, "ErrorCode", function() { return /* reexport */ ErrorCode; });
__webpack_require__.d(__webpack_exports__, "FormatError", function() { return /* reexport */ FormatError; });
__webpack_require__.d(__webpack_exports__, "InvalidValueError", function() { return /* reexport */ error_InvalidValueError; });
__webpack_require__.d(__webpack_exports__, "InvalidValueTypeError", function() { return /* reexport */ InvalidValueTypeError; });
__webpack_require__.d(__webpack_exports__, "MissingValueError", function() { return /* reexport */ MissingValueError; });

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/object/define-property.js
var define_property = __webpack_require__("RW1Z");
var define_property_default = /*#__PURE__*/__webpack_require__.n(define_property);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/array/is-array.js
var is_array = __webpack_require__("1A8d");
var is_array_default = /*#__PURE__*/__webpack_require__.n(is_array);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/object/keys.js
var keys = __webpack_require__("cUqe");
var keys_default = /*#__PURE__*/__webpack_require__.n(keys);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/instance/reduce.js
var reduce = __webpack_require__("XSsT");
var reduce_default = /*#__PURE__*/__webpack_require__.n(reduce);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/object/assign.js
var object_assign = __webpack_require__("kpPl");
var assign_default = /*#__PURE__*/__webpack_require__.n(object_assign);

// EXTERNAL MODULE: ../labels/node_modules/intl-messageformat-parser/lib/index.js + 2 modules
var lib = __webpack_require__("fZb7");

// CONCATENATED MODULE: /home/kaore/Dev/lib/oa/node_modules/intl-format-cache/lib/index.js
/*
Copyright (c) 2014, Yahoo! Inc. All rights reserved.
Copyrights licensed under the New BSD License.
See the accompanying LICENSE file for terms.
*/
var __spreadArrays = (undefined && undefined.__spreadArrays) || function () {
    for (var s = 0, i = 0, il = arguments.length; i < il; i++) s += arguments[i].length;
    for (var r = Array(s), k = 0, i = 0; i < il; i++)
        for (var a = arguments[i], j = 0, jl = a.length; j < jl; j++, k++)
            r[k] = a[j];
    return r;
};
// -- Utilities ----------------------------------------------------------------
function getCacheId(inputs) {
    return JSON.stringify(inputs.map(function (input) {
        return input && typeof input === 'object' ? orderedProps(input) : input;
    }));
}
function orderedProps(obj) {
    return Object.keys(obj)
        .sort()
        .map(function (k) {
        var _a;
        return (_a = {}, _a[k] = obj[k], _a);
    });
}
var memoizeFormatConstructor = function (FormatConstructor, cache) {
    if (cache === void 0) { cache = {}; }
    return function () {
        var _a;
        var args = [];
        for (var _i = 0; _i < arguments.length; _i++) {
            args[_i] = arguments[_i];
        }
        var cacheId = getCacheId(args);
        var format = cacheId && cache[cacheId];
        if (!format) {
            format = new ((_a = FormatConstructor).bind.apply(_a, __spreadArrays([void 0], args)))();
            if (cacheId) {
                cache[cacheId] = format;
            }
        }
        return format;
    };
};
/* harmony default export */ var intl_format_cache_lib = (memoizeFormatConstructor);
//# sourceMappingURL=index.js.map
// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/instance/map.js
var map = __webpack_require__("VluA");
var map_default = /*#__PURE__*/__webpack_require__.n(map);

// EXTERNAL MODULE: ../labels/node_modules/intl-messageformat-parser/lib/types.js
var types = __webpack_require__("CHFT");

// EXTERNAL MODULE: ../labels/node_modules/intl-messageformat-parser/lib/skeleton.js
var skeleton = __webpack_require__("S42S");

// EXTERNAL MODULE: /home/kaore/Dev/lib/oa/node_modules/core-js/modules/es.array.join.js
var es_array_join = __webpack_require__("7xRU");

// EXTERNAL MODULE: /home/kaore/Dev/lib/oa/node_modules/core-js/modules/es.object.to-string.js
var es_object_to_string = __webpack_require__("7x/C");

// EXTERNAL MODULE: /home/kaore/Dev/lib/oa/node_modules/core-js/modules/es.regexp.to-string.js
var es_regexp_to_string = __webpack_require__("DZ+c");

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/object/create.js
var create = __webpack_require__("UwuC");
var create_default = /*#__PURE__*/__webpack_require__.n(create);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/object/set-prototype-of.js
var set_prototype_of = __webpack_require__("tfi8");
var set_prototype_of_default = /*#__PURE__*/__webpack_require__.n(set_prototype_of);

// CONCATENATED MODULE: ../labels/node_modules/intl-messageformat/lib/error.js







var __extends = undefined && undefined.__extends || function () {
  var _extendStatics = function extendStatics(d, b) {
    _extendStatics = set_prototype_of_default.a || {
      __proto__: []
    } instanceof Array && function (d, b) {
      d.__proto__ = b;
    } || function (d, b) {
      for (var p in b) {
        if (b.hasOwnProperty(p)) d[p] = b[p];
      }
    };

    return _extendStatics(d, b);
  };

  return function (d, b) {
    _extendStatics(d, b);

    function __() {
      this.constructor = d;
    }

    d.prototype = b === null ? create_default()(b) : (__.prototype = b.prototype, new __());
  };
}();

var ErrorCode;

(function (ErrorCode) {
  // When we have a placeholder but no value to format
  ErrorCode["MISSING_VALUE"] = "MISSING_VALUE"; // When value supplied is invalid

  ErrorCode["INVALID_VALUE"] = "INVALID_VALUE"; // When we need specific Intl API but it's not available

  ErrorCode["MISSING_INTL_API"] = "MISSING_INTL_API";
})(ErrorCode || (ErrorCode = {}));

var FormatError =
/** @class */
function (_super) {
  __extends(FormatError, _super);

  function FormatError(msg, code, originalMessage) {
    var _this = _super.call(this, msg) || this;

    _this.code = code;
    _this.originalMessage = originalMessage;
    return _this;
  }

  FormatError.prototype.toString = function () {
    return "[formatjs Error: " + this.code + "] " + this.message;
  };

  return FormatError;
}(Error);



var error_InvalidValueError =
/** @class */
function (_super) {
  __extends(InvalidValueError, _super);

  function InvalidValueError(variableId, value, options, originalMessage) {
    return _super.call(this, "Invalid values for \"" + variableId + "\": \"" + value + "\". Options are \"" + keys_default()(options).join('", "') + "\"", "INVALID_VALUE"
    /* INVALID_VALUE */
    , originalMessage) || this;
  }

  return InvalidValueError;
}(FormatError);



var InvalidValueTypeError =
/** @class */
function (_super) {
  __extends(InvalidValueTypeError, _super);

  function InvalidValueTypeError(value, type, originalMessage) {
    return _super.call(this, "Value for \"" + value + "\" must be of type " + type, "INVALID_VALUE"
    /* INVALID_VALUE */
    , originalMessage) || this;
  }

  return InvalidValueTypeError;
}(FormatError);



var MissingValueError =
/** @class */
function (_super) {
  __extends(MissingValueError, _super);

  function MissingValueError(variableId, originalMessage) {
    return _super.call(this, "The intl string context variable \"" + variableId + "\" was not provided to the string \"" + originalMessage + "\"", "MISSING_VALUE"
    /* MISSING_VALUE */
    , originalMessage) || this;
  }

  return MissingValueError;
}(FormatError);


// CONCATENATED MODULE: ../labels/node_modules/intl-messageformat/lib/formatters.js






var PART_TYPE;

(function (PART_TYPE) {
  PART_TYPE[PART_TYPE["literal"] = 0] = "literal";
  PART_TYPE[PART_TYPE["object"] = 1] = "object";
})(PART_TYPE || (PART_TYPE = {}));

function mergeLiteral(parts) {
  if (parts.length < 2) {
    return parts;
  }

  return reduce_default()(parts).call(parts, function (all, part) {
    var lastPart = all[all.length - 1];

    if (!lastPart || lastPart.type !== 0
    /* literal */
    || part.type !== 0
    /* literal */
    ) {
        all.push(part);
      } else {
      lastPart.value += part.value;
    }

    return all;
  }, []);
}

function isFormatXMLElementFn(el) {
  return typeof el === 'function';
} // TODO(skeleton): add skeleton support

function formatToParts(els, locales, formatters, formats, values, currentPluralValue, // For debugging
originalMessage) {
  // Hot path for straight simple msg translations
  if (els.length === 1 && Object(types["h" /* isLiteralElement */])(els[0])) {
    return [{
      type: 0
      /* literal */
      ,
      value: els[0].value
    }];
  }

  var result = [];

  for (var _i = 0, els_1 = els; _i < els_1.length; _i++) {
    var el = els_1[_i]; // Exit early for string parts.

    if (Object(types["h" /* isLiteralElement */])(el)) {
      result.push({
        type: 0
        /* literal */
        ,
        value: el.value
      });
      continue;
    } // TODO: should this part be literal type?
    // Replace `#` in plural rules with the actual numeric value.


    if (Object(types["l" /* isPoundElement */])(el)) {
      if (typeof currentPluralValue === 'number') {
        result.push({
          type: 0
          /* literal */
          ,
          value: formatters.getNumberFormat(locales).format(currentPluralValue)
        });
      }

      continue;
    }

    var varName = el.value; // Enforce that all required values are provided by the caller.

    if (!(values && varName in values)) {
      throw new MissingValueError(varName, originalMessage);
    }

    var value = values[varName];

    if (Object(types["e" /* isArgumentElement */])(el)) {
      if (!value || typeof value === 'string' || typeof value === 'number') {
        value = typeof value === 'string' || typeof value === 'number' ? String(value) : '';
      }

      result.push({
        type: typeof value === 'string' ? 0
        /* literal */
        : 1
        /* object */
        ,
        value: value
      });
      continue;
    } // Recursively format plural and select parts' option — which can be a
    // nested pattern structure. The choosing of the option to use is
    // abstracted-by and delegated-to the part helper object.


    if (Object(types["f" /* isDateElement */])(el)) {
      var style = typeof el.style === 'string' ? formats.date[el.style] : Object(types["g" /* isDateTimeSkeleton */])(el.style) ? Object(skeleton["b" /* parseDateTimeSkeleton */])(el.style.pattern) : undefined;
      result.push({
        type: 0
        /* literal */
        ,
        value: formatters.getDateTimeFormat(locales, style).format(value)
      });
      continue;
    }

    if (Object(types["o" /* isTimeElement */])(el)) {
      var style = typeof el.style === 'string' ? formats.time[el.style] : Object(types["g" /* isDateTimeSkeleton */])(el.style) ? Object(skeleton["b" /* parseDateTimeSkeleton */])(el.style.pattern) : undefined;
      result.push({
        type: 0
        /* literal */
        ,
        value: formatters.getDateTimeFormat(locales, style).format(value)
      });
      continue;
    }

    if (Object(types["i" /* isNumberElement */])(el)) {
      var style = typeof el.style === 'string' ? formats.number[el.style] : Object(types["j" /* isNumberSkeleton */])(el.style) ? Object(skeleton["a" /* convertNumberSkeletonToNumberFormatOptions */])(el.style.tokens) : undefined;
      result.push({
        type: 0
        /* literal */
        ,
        value: formatters.getNumberFormat(locales, style).format(value)
      });
      continue;
    }

    if (Object(types["n" /* isTagElement */])(el)) {
      var children = el.children,
          value_1 = el.value;
      var formatFn = values[value_1];

      if (!isFormatXMLElementFn(formatFn)) {
        throw new InvalidValueTypeError(value_1, 'function', originalMessage);
      }

      var parts = formatToParts(children, locales, formatters, formats, values, currentPluralValue);
      var chunks = formatFn(map_default()(parts).call(parts, function (p) {
        return p.value;
      }));

      if (!is_array_default()(chunks)) {
        chunks = [chunks];
      }

      result.push.apply(result, map_default()(chunks).call(chunks, function (c) {
        return {
          type: typeof c === 'string' ? 0
          /* literal */
          : 1
          /* object */
          ,
          value: c
        };
      }));
    }

    if (Object(types["m" /* isSelectElement */])(el)) {
      var opt = el.options[value] || el.options.other;

      if (!opt) {
        throw new error_InvalidValueError(el.value, value, keys_default()(el.options), originalMessage);
      }

      result.push.apply(result, formatToParts(opt.value, locales, formatters, formats, values));
      continue;
    }

    if (Object(types["k" /* isPluralElement */])(el)) {
      var opt = el.options["=" + value];

      if (!opt) {
        if (!Intl.PluralRules) {
          throw new FormatError("Intl.PluralRules is not available in this environment.\nTry polyfilling it using \"@formatjs/intl-pluralrules\"\n", "MISSING_INTL_API"
          /* MISSING_INTL_API */
          , originalMessage);
        }

        var rule = formatters.getPluralRules(locales, {
          type: el.pluralType
        }).select(value - (el.offset || 0));
        opt = el.options[rule] || el.options.other;
      }

      if (!opt) {
        throw new error_InvalidValueError(el.value, value, keys_default()(el.options), originalMessage);
      }

      result.push.apply(result, formatToParts(opt.value, locales, formatters, formats, values, value - (el.offset || 0)));
      continue;
    }
  }

  return mergeLiteral(result);
}
// CONCATENATED MODULE: ../labels/node_modules/intl-messageformat/lib/core.js






/*
Copyright (c) 2014, Yahoo! Inc. All rights reserved.
Copyrights licensed under the New BSD License.
See the accompanying LICENSE file for terms.
*/
var __assign = undefined && undefined.__assign || function () {
  __assign = assign_default.a || function (t) {
    for (var s, i = 1, n = arguments.length; i < n; i++) {
      s = arguments[i];

      for (var p in s) {
        if (Object.prototype.hasOwnProperty.call(s, p)) t[p] = s[p];
      }
    }

    return t;
  };

  return __assign.apply(this, arguments);
};



 // -- MessageFormat --------------------------------------------------------

function mergeConfig(c1, c2) {
  var _context;

  if (!c2) {
    return c1;
  }

  return __assign(__assign(__assign({}, c1 || {}), c2 || {}), reduce_default()(_context = keys_default()(c1)).call(_context, function (all, k) {
    all[k] = __assign(__assign({}, c1[k]), c2[k] || {});
    return all;
  }, {}));
}

function mergeConfigs(defaultConfig, configs) {
  var _context2;

  if (!configs) {
    return defaultConfig;
  }

  return reduce_default()(_context2 = keys_default()(defaultConfig)).call(_context2, function (all, k) {
    all[k] = mergeConfig(defaultConfig[k], configs[k]);
    return all;
  }, __assign({}, defaultConfig));
}

function createDefaultFormatters(cache) {
  if (cache === void 0) {
    cache = {
      number: {},
      dateTime: {},
      pluralRules: {}
    };
  }

  return {
    getNumberFormat: intl_format_cache_lib(Intl.NumberFormat, cache.number),
    getDateTimeFormat: intl_format_cache_lib(Intl.DateTimeFormat, cache.dateTime),
    getPluralRules: intl_format_cache_lib(Intl.PluralRules, cache.pluralRules)
  };
}

var core_IntlMessageFormat =
/** @class */
function () {
  function IntlMessageFormat(message, locales, overrideFormats, opts) {
    var _this = this;

    if (locales === void 0) {
      locales = IntlMessageFormat.defaultLocale;
    }

    this.formatterCache = {
      number: {},
      dateTime: {},
      pluralRules: {}
    };

    this.format = function (values) {
      var parts = _this.formatToParts(values); // Hot path for straight simple msg translations


      if (parts.length === 1) {
        return parts[0].value;
      }

      var result = reduce_default()(parts).call(parts, function (all, part) {
        if (!all.length || part.type !== 0
        /* literal */
        || typeof all[all.length - 1] !== 'string') {
          all.push(part.value);
        } else {
          all[all.length - 1] += part.value;
        }

        return all;
      }, []);

      if (result.length <= 1) {
        return result[0] || '';
      }

      return result;
    };

    this.formatToParts = function (values) {
      return formatToParts(_this.ast, _this.locales, _this.formatters, _this.formats, values, undefined, _this.message);
    };

    this.resolvedOptions = function () {
      return {
        locale: Intl.NumberFormat.supportedLocalesOf(_this.locales)[0]
      };
    };

    this.getAst = function () {
      return _this.ast;
    };

    if (typeof message === 'string') {
      this.message = message;

      if (!IntlMessageFormat.__parse) {
        throw new TypeError('IntlMessageFormat.__parse must be set to process `message` of type `string`');
      } // Parse string messages into an AST.


      this.ast = IntlMessageFormat.__parse(message, {
        normalizeHashtagInPlural: false,
        ignoreTag: opts === null || opts === void 0 ? void 0 : opts.ignoreTag
      });
    } else {
      this.ast = message;
    }

    if (!is_array_default()(this.ast)) {
      throw new TypeError('A message must be provided as a String or AST.');
    } // Creates a new object with the specified `formats` merged with the default
    // formats.


    this.formats = mergeConfigs(IntlMessageFormat.formats, overrideFormats); // Defined first because it's used to build the format pattern.

    this.locales = locales;
    this.formatters = opts && opts.formatters || createDefaultFormatters(this.formatterCache);
  }

  define_property_default()(IntlMessageFormat, "defaultLocale", {
    get: function get() {
      if (!IntlMessageFormat.memoizedDefaultLocale) {
        IntlMessageFormat.memoizedDefaultLocale = new Intl.NumberFormat().resolvedOptions().locale;
      }

      return IntlMessageFormat.memoizedDefaultLocale;
    },
    enumerable: true,
    configurable: true
  });

  IntlMessageFormat.memoizedDefaultLocale = null;
  IntlMessageFormat.__parse = lib["parse"]; // Default format options used as the prototype of the `formats` provided to the
  // constructor. These are used when constructing the internal Intl.NumberFormat
  // and Intl.DateTimeFormat instances.

  IntlMessageFormat.formats = {
    number: {
      currency: {
        style: 'currency'
      },
      percent: {
        style: 'percent'
      }
    },
    date: {
      short: {
        month: 'numeric',
        day: 'numeric',
        year: '2-digit'
      },
      medium: {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
      },
      long: {
        month: 'long',
        day: 'numeric',
        year: 'numeric'
      },
      full: {
        weekday: 'long',
        month: 'long',
        day: 'numeric',
        year: 'numeric'
      }
    },
    time: {
      short: {
        hour: 'numeric',
        minute: 'numeric'
      },
      medium: {
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric'
      },
      long: {
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        timeZoneName: 'short'
      },
      full: {
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        timeZoneName: 'short'
      }
    }
  };
  return IntlMessageFormat;
}();


/* harmony default export */ var core = (core_IntlMessageFormat);
// CONCATENATED MODULE: ../labels/node_modules/intl-messageformat/lib/index.js
/*
Copyright (c) 2014, Yahoo! Inc. All rights reserved.
Copyrights licensed under the New BSD License.
See the accompanying LICENSE file for terms.
*/




/* harmony default export */ var intl_messageformat_lib = __webpack_exports__["default"] = (core);

/***/ }),

/***/ "CD8Q":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("dSaG");

// `ToPrimitive` abstract operation
// https://tc39.github.io/ecma262/#sec-toprimitive
// instead of the ES6 spec version, we didn't implement @@toPrimitive case
// and the second argument - flag - preferred type is a string
module.exports = function (input, PREFERRED_STRING) {
  if (!isObject(input)) return input;
  var fn, val;
  if (PREFERRED_STRING && typeof (fn = input.toString) == 'function' && !isObject(val = fn.call(input))) return val;
  if (typeof (fn = input.valueOf) == 'function' && !isObject(val = fn.call(input))) return val;
  if (!PREFERRED_STRING && typeof (fn = input.toString) == 'function' && !isObject(val = fn.call(input))) return val;
  throw TypeError("Can't convert object to primitive value");
};


/***/ }),

/***/ "CHFT":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return TYPE; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return SKELETON_TYPE; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "h", function() { return isLiteralElement; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "e", function() { return isArgumentElement; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "i", function() { return isNumberElement; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "f", function() { return isDateElement; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "o", function() { return isTimeElement; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "m", function() { return isSelectElement; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "k", function() { return isPluralElement; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "l", function() { return isPoundElement; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "n", function() { return isTagElement; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "j", function() { return isNumberSkeleton; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "g", function() { return isDateTimeSkeleton; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return createLiteralElement; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return createNumberElement; });
/* harmony import */ var _babel_runtime_corejs3_helpers_typeof__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("QG4m");
/* harmony import */ var _babel_runtime_corejs3_helpers_typeof__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_helpers_typeof__WEBPACK_IMPORTED_MODULE_0__);

var TYPE;

(function (TYPE) {
  /**
   * Raw text
   */
  TYPE[TYPE["literal"] = 0] = "literal";
  /**
   * Variable w/o any format, e.g `var` in `this is a {var}`
   */

  TYPE[TYPE["argument"] = 1] = "argument";
  /**
   * Variable w/ number format
   */

  TYPE[TYPE["number"] = 2] = "number";
  /**
   * Variable w/ date format
   */

  TYPE[TYPE["date"] = 3] = "date";
  /**
   * Variable w/ time format
   */

  TYPE[TYPE["time"] = 4] = "time";
  /**
   * Variable w/ select format
   */

  TYPE[TYPE["select"] = 5] = "select";
  /**
   * Variable w/ plural format
   */

  TYPE[TYPE["plural"] = 6] = "plural";
  /**
   * Only possible within plural argument.
   * This is the `#` symbol that will be substituted with the count.
   */

  TYPE[TYPE["pound"] = 7] = "pound";
  /**
   * XML-like tag
   */

  TYPE[TYPE["tag"] = 8] = "tag";
})(TYPE || (TYPE = {}));

var SKELETON_TYPE;

(function (SKELETON_TYPE) {
  SKELETON_TYPE[SKELETON_TYPE["number"] = 0] = "number";
  SKELETON_TYPE[SKELETON_TYPE["dateTime"] = 1] = "dateTime";
})(SKELETON_TYPE || (SKELETON_TYPE = {}));
/**
 * Type Guards
 */


function isLiteralElement(el) {
  return el.type === TYPE.literal;
}
function isArgumentElement(el) {
  return el.type === TYPE.argument;
}
function isNumberElement(el) {
  return el.type === TYPE.number;
}
function isDateElement(el) {
  return el.type === TYPE.date;
}
function isTimeElement(el) {
  return el.type === TYPE.time;
}
function isSelectElement(el) {
  return el.type === TYPE.select;
}
function isPluralElement(el) {
  return el.type === TYPE.plural;
}
function isPoundElement(el) {
  return el.type === TYPE.pound;
}
function isTagElement(el) {
  return el.type === TYPE.tag;
}
function isNumberSkeleton(el) {
  return !!(el && _babel_runtime_corejs3_helpers_typeof__WEBPACK_IMPORTED_MODULE_0___default()(el) === 'object' && el.type === 0
  /* number */
  );
}
function isDateTimeSkeleton(el) {
  return !!(el && _babel_runtime_corejs3_helpers_typeof__WEBPACK_IMPORTED_MODULE_0___default()(el) === 'object' && el.type === 1
  /* dateTime */
  );
}
function createLiteralElement(value) {
  return {
    type: TYPE.literal,
    value: value
  };
}
function createNumberElement(value, style) {
  return {
    type: TYPE.number,
    value: value,
    style: style
  };
}

/***/ }),

/***/ "Ch6y":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var getBuiltIn = __webpack_require__("VCi3");
var definePropertyModule = __webpack_require__("q9+l");
var wellKnownSymbol = __webpack_require__("fVMg");
var DESCRIPTORS = __webpack_require__("1Mu/");

var SPECIES = wellKnownSymbol('species');

module.exports = function (CONSTRUCTOR_NAME) {
  var Constructor = getBuiltIn(CONSTRUCTOR_NAME);
  var defineProperty = definePropertyModule.f;

  if (DESCRIPTORS && Constructor && !Constructor[SPECIES]) {
    defineProperty(Constructor, SPECIES, {
      configurable: true,
      get: function () { return this; }
    });
  }
};


/***/ }),

/***/ "CtlU":
/***/ (function(module, exports, __webpack_require__) {

var TO_STRING_TAG_SUPPORT = __webpack_require__("WbkG");
var defineProperty = __webpack_require__("JliG").f;
var createNonEnumerableProperty = __webpack_require__("jNzf");
var has = __webpack_require__("zNvU");
var toString = __webpack_require__("x4oI");
var wellKnownSymbol = __webpack_require__("HVcX");

var TO_STRING_TAG = wellKnownSymbol('toStringTag');

module.exports = function (it, TAG, STATIC, SET_METHOD) {
  if (it) {
    var target = STATIC ? it : it.prototype;
    if (!has(target, TO_STRING_TAG)) {
      defineProperty(target, TO_STRING_TAG, { configurable: true, value: TAG });
    }
    if (SET_METHOD && !TO_STRING_TAG_SUPPORT) {
      createNonEnumerableProperty(target, 'toString', toString);
    }
  }
};


/***/ }),

/***/ "DEeE":
/***/ (function(module, exports, __webpack_require__) {

var internalObjectKeys = __webpack_require__("yRya");
var enumBugKeys = __webpack_require__("sX5C");

// `Object.keys` method
// https://tc39.github.io/ecma262/#sec-object.keys
module.exports = Object.keys || function keys(O) {
  return internalObjectKeys(O, enumBugKeys);
};


/***/ }),

/***/ "DMYm":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("n9AK");
var fails = __webpack_require__("XU0c");
var isArray = __webpack_require__("ygwS");
var isObject = __webpack_require__("H3h0");
var toObject = __webpack_require__("quhl");
var toLength = __webpack_require__("Gpqx");
var createProperty = __webpack_require__("1FCb");
var arraySpeciesCreate = __webpack_require__("0q0E");
var arrayMethodHasSpeciesSupport = __webpack_require__("nB+7");
var wellKnownSymbol = __webpack_require__("HVcX");
var V8_VERSION = __webpack_require__("Qb90");

var IS_CONCAT_SPREADABLE = wellKnownSymbol('isConcatSpreadable');
var MAX_SAFE_INTEGER = 0x1FFFFFFFFFFFFF;
var MAXIMUM_ALLOWED_INDEX_EXCEEDED = 'Maximum allowed index exceeded';

// We can't use this feature detection in V8 since it causes
// deoptimization and serious performance degradation
// https://github.com/zloirock/core-js/issues/679
var IS_CONCAT_SPREADABLE_SUPPORT = V8_VERSION >= 51 || !fails(function () {
  var array = [];
  array[IS_CONCAT_SPREADABLE] = false;
  return array.concat()[0] !== array;
});

var SPECIES_SUPPORT = arrayMethodHasSpeciesSupport('concat');

var isConcatSpreadable = function (O) {
  if (!isObject(O)) return false;
  var spreadable = O[IS_CONCAT_SPREADABLE];
  return spreadable !== undefined ? !!spreadable : isArray(O);
};

var FORCED = !IS_CONCAT_SPREADABLE_SUPPORT || !SPECIES_SUPPORT;

// `Array.prototype.concat` method
// https://tc39.github.io/ecma262/#sec-array.prototype.concat
// with adding support of @@isConcatSpreadable and @@species
$({ target: 'Array', proto: true, forced: FORCED }, {
  concat: function concat(arg) { // eslint-disable-line no-unused-vars
    var O = toObject(this);
    var A = arraySpeciesCreate(O, 0);
    var n = 0;
    var i, k, length, len, E;
    for (i = -1, length = arguments.length; i < length; i++) {
      E = i === -1 ? O : arguments[i];
      if (isConcatSpreadable(E)) {
        len = toLength(E.length);
        if (n + len > MAX_SAFE_INTEGER) throw TypeError(MAXIMUM_ALLOWED_INDEX_EXCEEDED);
        for (k = 0; k < len; k++, n++) if (k in E) createProperty(A, n, E[k]);
      } else {
        if (n >= MAX_SAFE_INTEGER) throw TypeError(MAXIMUM_ALLOWED_INDEX_EXCEEDED);
        createProperty(A, n++, E);
      }
    }
    A.length = n;
    return A;
  }
});


/***/ }),

/***/ "DTge":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var IteratorPrototype = __webpack_require__("/L0j").IteratorPrototype;
var create = __webpack_require__("By9b");
var createPropertyDescriptor = __webpack_require__("96pp");
var setToStringTag = __webpack_require__("CtlU");
var Iterators = __webpack_require__("m/wn");

var returnThis = function () { return this; };

module.exports = function (IteratorConstructor, NAME, next) {
  var TO_STRING_TAG = NAME + ' Iterator';
  IteratorConstructor.prototype = create(IteratorPrototype, { next: createPropertyDescriptor(1, next) });
  setToStringTag(IteratorConstructor, TO_STRING_TAG, false, true);
  Iterators[TO_STRING_TAG] = returnThis;
  return IteratorConstructor;
};


/***/ }),

/***/ "DZ+c":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var redefine = __webpack_require__("uLp7");
var anObject = __webpack_require__("FXyv");
var fails = __webpack_require__("ct80");
var flags = __webpack_require__("q/0V");

var TO_STRING = 'toString';
var RegExpPrototype = RegExp.prototype;
var nativeToString = RegExpPrototype[TO_STRING];

var NOT_GENERIC = fails(function () { return nativeToString.call({ source: 'a', flags: 'b' }) != '/a/b'; });
// FF44- RegExp#toString has a wrong name
var INCORRECT_NAME = nativeToString.name != TO_STRING;

// `RegExp.prototype.toString` method
// https://tc39.github.io/ecma262/#sec-regexp.prototype.tostring
if (NOT_GENERIC || INCORRECT_NAME) {
  redefine(RegExp.prototype, TO_STRING, function toString() {
    var R = anObject(this);
    var p = String(R.source);
    var rf = R.flags;
    var f = String(rf === undefined && R instanceof RegExp && !('flags' in RegExpPrototype) ? flags.call(R) : rf);
    return '/' + p + '/' + f;
  }, { unsafe: true });
}


/***/ }),

/***/ "DpO5":
/***/ (function(module, exports) {

module.exports = false;


/***/ }),

/***/ "E8k3":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("H3h0");

module.exports = function (it) {
  if (!isObject(it) && it !== null) {
    throw TypeError("Can't set " + String(it) + ' as a prototype');
  } return it;
};


/***/ }),

/***/ "EZwN":
/***/ (function(module, exports, __webpack_require__) {

var NATIVE_SYMBOL = __webpack_require__("5TyG");

module.exports = NATIVE_SYMBOL
  // eslint-disable-next-line no-undef
  && !Symbol.sham
  // eslint-disable-next-line no-undef
  && typeof Symbol.iterator == 'symbol';


/***/ }),

/***/ "Ew2P":
/***/ (function(module, exports) {

// iterable DOM collections
// flag - `iterable` interface - 'entries', 'keys', 'values', 'forEach' methods
module.exports = {
  CSSRuleList: 0,
  CSSStyleDeclaration: 0,
  CSSValueList: 0,
  ClientRectList: 0,
  DOMRectList: 0,
  DOMStringList: 0,
  DOMTokenList: 1,
  DataTransferItemList: 0,
  FileList: 0,
  HTMLAllCollection: 0,
  HTMLCollection: 0,
  HTMLFormElement: 0,
  HTMLSelectElement: 0,
  MediaList: 0,
  MimeTypeArray: 0,
  NamedNodeMap: 0,
  NodeList: 1,
  PaintRequestList: 0,
  Plugin: 0,
  PluginArray: 0,
  SVGLengthList: 0,
  SVGNumberList: 0,
  SVGPathSegList: 0,
  SVGPointList: 0,
  SVGStringList: 0,
  SVGTransformList: 0,
  SourceBufferList: 0,
  StyleSheetList: 0,
  TextTrackCueList: 0,
  TextTrackList: 0,
  TouchList: 0
};


/***/ }),

/***/ "F63i":
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),

/***/ "FVjd":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("NSkT");

/***/ }),

/***/ "FXyv":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("dSaG");

module.exports = function (it) {
  if (!isObject(it)) {
    throw TypeError(String(it) + ' is not an object');
  } return it;
};


/***/ }),

/***/ "FszS":
/***/ (function(module, exports) {

// iterable DOM collections
// flag - `iterable` interface - 'entries', 'keys', 'values', 'forEach' methods
module.exports = {
  CSSRuleList: 0,
  CSSStyleDeclaration: 0,
  CSSValueList: 0,
  ClientRectList: 0,
  DOMRectList: 0,
  DOMStringList: 0,
  DOMTokenList: 1,
  DataTransferItemList: 0,
  FileList: 0,
  HTMLAllCollection: 0,
  HTMLCollection: 0,
  HTMLFormElement: 0,
  HTMLSelectElement: 0,
  MediaList: 0,
  MimeTypeArray: 0,
  NamedNodeMap: 0,
  NodeList: 1,
  PaintRequestList: 0,
  Plugin: 0,
  PluginArray: 0,
  SVGLengthList: 0,
  SVGNumberList: 0,
  SVGPathSegList: 0,
  SVGPointList: 0,
  SVGStringList: 0,
  SVGTransformList: 0,
  SourceBufferList: 0,
  StyleSheetList: 0,
  TextTrackCueList: 0,
  TextTrackList: 0,
  TouchList: 0
};


/***/ }),

/***/ "Fu/f":
/***/ (function(module, exports, __webpack_require__) {

var trim = __webpack_require__("L1sM");

var StringPrototype = String.prototype;

module.exports = function (it) {
  var own = it.trim;
  return typeof it === 'string' || it === StringPrototype
    || (it instanceof String && own === StringPrototype.trim) ? trim : own;
};


/***/ }),

/***/ "GBkV":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("tTj0");

/***/ }),

/***/ "GFpt":
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__("1Mu/");
var propertyIsEnumerableModule = __webpack_require__("4Sk5");
var createPropertyDescriptor = __webpack_require__("lhjL");
var toIndexedObject = __webpack_require__("N4z3");
var toPrimitive = __webpack_require__("CD8Q");
var has = __webpack_require__("8aeu");
var IE8_DOM_DEFINE = __webpack_require__("fD9S");

var nativeGetOwnPropertyDescriptor = Object.getOwnPropertyDescriptor;

// `Object.getOwnPropertyDescriptor` method
// https://tc39.github.io/ecma262/#sec-object.getownpropertydescriptor
exports.f = DESCRIPTORS ? nativeGetOwnPropertyDescriptor : function getOwnPropertyDescriptor(O, P) {
  O = toIndexedObject(O);
  P = toPrimitive(P, true);
  if (IE8_DOM_DEFINE) try {
    return nativeGetOwnPropertyDescriptor(O, P);
  } catch (error) { /* empty */ }
  if (has(O, P)) return createPropertyDescriptor(!propertyIsEnumerableModule.f.call(O, P), O[P]);
};


/***/ }),

/***/ "Gfq3":
/***/ (function(module, exports, __webpack_require__) {

var path = __webpack_require__("j0PW");

module.exports = function (CONSTRUCTOR) {
  return path[CONSTRUCTOR + 'Prototype'];
};


/***/ }),

/***/ "GnwC":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("+N5y");
var entryVirtual = __webpack_require__("Gfq3");

module.exports = entryVirtual('Array').map;


/***/ }),

/***/ "Gpqx":
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__("lWVH");

var min = Math.min;

// `ToLength` abstract operation
// https://tc39.github.io/ecma262/#sec-tolength
module.exports = function (argument) {
  return argument > 0 ? min(toInteger(argument), 0x1FFFFFFFFFFFFF) : 0; // 2 ** 53 - 1 == 9007199254740991
};


/***/ }),

/***/ "GwNf":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("Sj6f");

/***/ }),

/***/ "H17f":
/***/ (function(module, exports, __webpack_require__) {

var toIndexedObject = __webpack_require__("N4z3");
var toLength = __webpack_require__("tJVe");
var toAbsoluteIndex = __webpack_require__("mg+6");

// `Array.prototype.{ indexOf, includes }` methods implementation
var createMethod = function (IS_INCLUDES) {
  return function ($this, el, fromIndex) {
    var O = toIndexedObject($this);
    var length = toLength(O.length);
    var index = toAbsoluteIndex(fromIndex, length);
    var value;
    // Array#includes uses SameValueZero equality algorithm
    // eslint-disable-next-line no-self-compare
    if (IS_INCLUDES && el != el) while (length > index) {
      value = O[index++];
      // eslint-disable-next-line no-self-compare
      if (value != value) return true;
    // Array#indexOf ignores holes, Array#includes - not
    } else for (;length > index; index++) {
      if ((IS_INCLUDES || index in O) && O[index] === el) return IS_INCLUDES || index || 0;
    } return !IS_INCLUDES && -1;
  };
};

module.exports = {
  // `Array.prototype.includes` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.includes
  includes: createMethod(true),
  // `Array.prototype.indexOf` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.indexof
  indexOf: createMethod(false)
};


/***/ }),

/***/ "H3h0":
/***/ (function(module, exports) {

module.exports = function (it) {
  return typeof it === 'object' ? it !== null : typeof it === 'function';
};


/***/ }),

/***/ "HVcX":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("oNh+");
var shared = __webpack_require__("PLru");
var has = __webpack_require__("zNvU");
var uid = __webpack_require__("apkA");
var NATIVE_SYMBOL = __webpack_require__("5TyG");
var USE_SYMBOL_AS_UID = __webpack_require__("EZwN");

var WellKnownSymbolsStore = shared('wks');
var Symbol = global.Symbol;
var createWellKnownSymbol = USE_SYMBOL_AS_UID ? Symbol : Symbol && Symbol.withoutSetter || uid;

module.exports = function (name) {
  if (!has(WellKnownSymbolsStore, name)) {
    if (NATIVE_SYMBOL && has(Symbol, name)) WellKnownSymbolsStore[name] = Symbol[name];
    else WellKnownSymbolsStore[name] = createWellKnownSymbol('Symbol.' + name);
  } return WellKnownSymbolsStore[name];
};


/***/ }),

/***/ "HWa3":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("xDPO");

module.exports = parent;


/***/ }),

/***/ "HXNI":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("n9AK");
var global = __webpack_require__("oNh+");
var getBuiltIn = __webpack_require__("wF8L");
var IS_PURE = __webpack_require__("Vl7J");
var DESCRIPTORS = __webpack_require__("5Jdw");
var NATIVE_SYMBOL = __webpack_require__("5TyG");
var USE_SYMBOL_AS_UID = __webpack_require__("EZwN");
var fails = __webpack_require__("XU0c");
var has = __webpack_require__("zNvU");
var isArray = __webpack_require__("ygwS");
var isObject = __webpack_require__("H3h0");
var anObject = __webpack_require__("LTNl");
var toObject = __webpack_require__("quhl");
var toIndexedObject = __webpack_require__("VcbD");
var toPrimitive = __webpack_require__("3Mt6");
var createPropertyDescriptor = __webpack_require__("96pp");
var nativeObjectCreate = __webpack_require__("By9b");
var objectKeys = __webpack_require__("nKVx");
var getOwnPropertyNamesModule = __webpack_require__("x+gH");
var getOwnPropertyNamesExternal = __webpack_require__("8qN7");
var getOwnPropertySymbolsModule = __webpack_require__("iYt3");
var getOwnPropertyDescriptorModule = __webpack_require__("c9aA");
var definePropertyModule = __webpack_require__("JliG");
var propertyIsEnumerableModule = __webpack_require__("0foe");
var createNonEnumerableProperty = __webpack_require__("jNzf");
var redefine = __webpack_require__("yX36");
var shared = __webpack_require__("PLru");
var sharedKey = __webpack_require__("iDMO");
var hiddenKeys = __webpack_require__("lyTg");
var uid = __webpack_require__("apkA");
var wellKnownSymbol = __webpack_require__("HVcX");
var wrappedWellKnownSymbolModule = __webpack_require__("wuos");
var defineWellKnownSymbol = __webpack_require__("tCEB");
var setToStringTag = __webpack_require__("CtlU");
var InternalStateModule = __webpack_require__("WRdu");
var $forEach = __webpack_require__("zDWZ").forEach;

var HIDDEN = sharedKey('hidden');
var SYMBOL = 'Symbol';
var PROTOTYPE = 'prototype';
var TO_PRIMITIVE = wellKnownSymbol('toPrimitive');
var setInternalState = InternalStateModule.set;
var getInternalState = InternalStateModule.getterFor(SYMBOL);
var ObjectPrototype = Object[PROTOTYPE];
var $Symbol = global.Symbol;
var $stringify = getBuiltIn('JSON', 'stringify');
var nativeGetOwnPropertyDescriptor = getOwnPropertyDescriptorModule.f;
var nativeDefineProperty = definePropertyModule.f;
var nativeGetOwnPropertyNames = getOwnPropertyNamesExternal.f;
var nativePropertyIsEnumerable = propertyIsEnumerableModule.f;
var AllSymbols = shared('symbols');
var ObjectPrototypeSymbols = shared('op-symbols');
var StringToSymbolRegistry = shared('string-to-symbol-registry');
var SymbolToStringRegistry = shared('symbol-to-string-registry');
var WellKnownSymbolsStore = shared('wks');
var QObject = global.QObject;
// Don't use setters in Qt Script, https://github.com/zloirock/core-js/issues/173
var USE_SETTER = !QObject || !QObject[PROTOTYPE] || !QObject[PROTOTYPE].findChild;

// fallback for old Android, https://code.google.com/p/v8/issues/detail?id=687
var setSymbolDescriptor = DESCRIPTORS && fails(function () {
  return nativeObjectCreate(nativeDefineProperty({}, 'a', {
    get: function () { return nativeDefineProperty(this, 'a', { value: 7 }).a; }
  })).a != 7;
}) ? function (O, P, Attributes) {
  var ObjectPrototypeDescriptor = nativeGetOwnPropertyDescriptor(ObjectPrototype, P);
  if (ObjectPrototypeDescriptor) delete ObjectPrototype[P];
  nativeDefineProperty(O, P, Attributes);
  if (ObjectPrototypeDescriptor && O !== ObjectPrototype) {
    nativeDefineProperty(ObjectPrototype, P, ObjectPrototypeDescriptor);
  }
} : nativeDefineProperty;

var wrap = function (tag, description) {
  var symbol = AllSymbols[tag] = nativeObjectCreate($Symbol[PROTOTYPE]);
  setInternalState(symbol, {
    type: SYMBOL,
    tag: tag,
    description: description
  });
  if (!DESCRIPTORS) symbol.description = description;
  return symbol;
};

var isSymbol = USE_SYMBOL_AS_UID ? function (it) {
  return typeof it == 'symbol';
} : function (it) {
  return Object(it) instanceof $Symbol;
};

var $defineProperty = function defineProperty(O, P, Attributes) {
  if (O === ObjectPrototype) $defineProperty(ObjectPrototypeSymbols, P, Attributes);
  anObject(O);
  var key = toPrimitive(P, true);
  anObject(Attributes);
  if (has(AllSymbols, key)) {
    if (!Attributes.enumerable) {
      if (!has(O, HIDDEN)) nativeDefineProperty(O, HIDDEN, createPropertyDescriptor(1, {}));
      O[HIDDEN][key] = true;
    } else {
      if (has(O, HIDDEN) && O[HIDDEN][key]) O[HIDDEN][key] = false;
      Attributes = nativeObjectCreate(Attributes, { enumerable: createPropertyDescriptor(0, false) });
    } return setSymbolDescriptor(O, key, Attributes);
  } return nativeDefineProperty(O, key, Attributes);
};

var $defineProperties = function defineProperties(O, Properties) {
  anObject(O);
  var properties = toIndexedObject(Properties);
  var keys = objectKeys(properties).concat($getOwnPropertySymbols(properties));
  $forEach(keys, function (key) {
    if (!DESCRIPTORS || $propertyIsEnumerable.call(properties, key)) $defineProperty(O, key, properties[key]);
  });
  return O;
};

var $create = function create(O, Properties) {
  return Properties === undefined ? nativeObjectCreate(O) : $defineProperties(nativeObjectCreate(O), Properties);
};

var $propertyIsEnumerable = function propertyIsEnumerable(V) {
  var P = toPrimitive(V, true);
  var enumerable = nativePropertyIsEnumerable.call(this, P);
  if (this === ObjectPrototype && has(AllSymbols, P) && !has(ObjectPrototypeSymbols, P)) return false;
  return enumerable || !has(this, P) || !has(AllSymbols, P) || has(this, HIDDEN) && this[HIDDEN][P] ? enumerable : true;
};

var $getOwnPropertyDescriptor = function getOwnPropertyDescriptor(O, P) {
  var it = toIndexedObject(O);
  var key = toPrimitive(P, true);
  if (it === ObjectPrototype && has(AllSymbols, key) && !has(ObjectPrototypeSymbols, key)) return;
  var descriptor = nativeGetOwnPropertyDescriptor(it, key);
  if (descriptor && has(AllSymbols, key) && !(has(it, HIDDEN) && it[HIDDEN][key])) {
    descriptor.enumerable = true;
  }
  return descriptor;
};

var $getOwnPropertyNames = function getOwnPropertyNames(O) {
  var names = nativeGetOwnPropertyNames(toIndexedObject(O));
  var result = [];
  $forEach(names, function (key) {
    if (!has(AllSymbols, key) && !has(hiddenKeys, key)) result.push(key);
  });
  return result;
};

var $getOwnPropertySymbols = function getOwnPropertySymbols(O) {
  var IS_OBJECT_PROTOTYPE = O === ObjectPrototype;
  var names = nativeGetOwnPropertyNames(IS_OBJECT_PROTOTYPE ? ObjectPrototypeSymbols : toIndexedObject(O));
  var result = [];
  $forEach(names, function (key) {
    if (has(AllSymbols, key) && (!IS_OBJECT_PROTOTYPE || has(ObjectPrototype, key))) {
      result.push(AllSymbols[key]);
    }
  });
  return result;
};

// `Symbol` constructor
// https://tc39.github.io/ecma262/#sec-symbol-constructor
if (!NATIVE_SYMBOL) {
  $Symbol = function Symbol() {
    if (this instanceof $Symbol) throw TypeError('Symbol is not a constructor');
    var description = !arguments.length || arguments[0] === undefined ? undefined : String(arguments[0]);
    var tag = uid(description);
    var setter = function (value) {
      if (this === ObjectPrototype) setter.call(ObjectPrototypeSymbols, value);
      if (has(this, HIDDEN) && has(this[HIDDEN], tag)) this[HIDDEN][tag] = false;
      setSymbolDescriptor(this, tag, createPropertyDescriptor(1, value));
    };
    if (DESCRIPTORS && USE_SETTER) setSymbolDescriptor(ObjectPrototype, tag, { configurable: true, set: setter });
    return wrap(tag, description);
  };

  redefine($Symbol[PROTOTYPE], 'toString', function toString() {
    return getInternalState(this).tag;
  });

  redefine($Symbol, 'withoutSetter', function (description) {
    return wrap(uid(description), description);
  });

  propertyIsEnumerableModule.f = $propertyIsEnumerable;
  definePropertyModule.f = $defineProperty;
  getOwnPropertyDescriptorModule.f = $getOwnPropertyDescriptor;
  getOwnPropertyNamesModule.f = getOwnPropertyNamesExternal.f = $getOwnPropertyNames;
  getOwnPropertySymbolsModule.f = $getOwnPropertySymbols;

  wrappedWellKnownSymbolModule.f = function (name) {
    return wrap(wellKnownSymbol(name), name);
  };

  if (DESCRIPTORS) {
    // https://github.com/tc39/proposal-Symbol-description
    nativeDefineProperty($Symbol[PROTOTYPE], 'description', {
      configurable: true,
      get: function description() {
        return getInternalState(this).description;
      }
    });
    if (!IS_PURE) {
      redefine(ObjectPrototype, 'propertyIsEnumerable', $propertyIsEnumerable, { unsafe: true });
    }
  }
}

$({ global: true, wrap: true, forced: !NATIVE_SYMBOL, sham: !NATIVE_SYMBOL }, {
  Symbol: $Symbol
});

$forEach(objectKeys(WellKnownSymbolsStore), function (name) {
  defineWellKnownSymbol(name);
});

$({ target: SYMBOL, stat: true, forced: !NATIVE_SYMBOL }, {
  // `Symbol.for` method
  // https://tc39.github.io/ecma262/#sec-symbol.for
  'for': function (key) {
    var string = String(key);
    if (has(StringToSymbolRegistry, string)) return StringToSymbolRegistry[string];
    var symbol = $Symbol(string);
    StringToSymbolRegistry[string] = symbol;
    SymbolToStringRegistry[symbol] = string;
    return symbol;
  },
  // `Symbol.keyFor` method
  // https://tc39.github.io/ecma262/#sec-symbol.keyfor
  keyFor: function keyFor(sym) {
    if (!isSymbol(sym)) throw TypeError(sym + ' is not a symbol');
    if (has(SymbolToStringRegistry, sym)) return SymbolToStringRegistry[sym];
  },
  useSetter: function () { USE_SETTER = true; },
  useSimple: function () { USE_SETTER = false; }
});

$({ target: 'Object', stat: true, forced: !NATIVE_SYMBOL, sham: !DESCRIPTORS }, {
  // `Object.create` method
  // https://tc39.github.io/ecma262/#sec-object.create
  create: $create,
  // `Object.defineProperty` method
  // https://tc39.github.io/ecma262/#sec-object.defineproperty
  defineProperty: $defineProperty,
  // `Object.defineProperties` method
  // https://tc39.github.io/ecma262/#sec-object.defineproperties
  defineProperties: $defineProperties,
  // `Object.getOwnPropertyDescriptor` method
  // https://tc39.github.io/ecma262/#sec-object.getownpropertydescriptors
  getOwnPropertyDescriptor: $getOwnPropertyDescriptor
});

$({ target: 'Object', stat: true, forced: !NATIVE_SYMBOL }, {
  // `Object.getOwnPropertyNames` method
  // https://tc39.github.io/ecma262/#sec-object.getownpropertynames
  getOwnPropertyNames: $getOwnPropertyNames,
  // `Object.getOwnPropertySymbols` method
  // https://tc39.github.io/ecma262/#sec-object.getownpropertysymbols
  getOwnPropertySymbols: $getOwnPropertySymbols
});

// Chrome 38 and 39 `Object.getOwnPropertySymbols` fails on primitives
// https://bugs.chromium.org/p/v8/issues/detail?id=3443
$({ target: 'Object', stat: true, forced: fails(function () { getOwnPropertySymbolsModule.f(1); }) }, {
  getOwnPropertySymbols: function getOwnPropertySymbols(it) {
    return getOwnPropertySymbolsModule.f(toObject(it));
  }
});

// `JSON.stringify` method behavior with symbols
// https://tc39.github.io/ecma262/#sec-json.stringify
if ($stringify) {
  var FORCED_JSON_STRINGIFY = !NATIVE_SYMBOL || fails(function () {
    var symbol = $Symbol();
    // MS Edge converts symbol values to JSON as {}
    return $stringify([symbol]) != '[null]'
      // WebKit converts symbol values to JSON as null
      || $stringify({ a: symbol }) != '{}'
      // V8 throws on boxed symbols
      || $stringify(Object(symbol)) != '{}';
  });

  $({ target: 'JSON', stat: true, forced: FORCED_JSON_STRINGIFY }, {
    // eslint-disable-next-line no-unused-vars
    stringify: function stringify(it, replacer, space) {
      var args = [it];
      var index = 1;
      var $replacer;
      while (arguments.length > index) args.push(arguments[index++]);
      $replacer = replacer;
      if (!isObject(replacer) && it === undefined || isSymbol(it)) return; // IE8 returns string on undefined
      if (!isArray(replacer)) replacer = function (key, value) {
        if (typeof $replacer == 'function') value = $replacer.call(this, key, value);
        if (!isSymbol(value)) return value;
      };
      args[1] = replacer;
      return $stringify.apply(null, args);
    }
  });
}

// `Symbol.prototype[@@toPrimitive]` method
// https://tc39.github.io/ecma262/#sec-symbol.prototype-@@toprimitive
if (!$Symbol[PROTOTYPE][TO_PRIMITIVE]) {
  createNonEnumerableProperty($Symbol[PROTOTYPE], TO_PRIMITIVE, $Symbol[PROTOTYPE].valueOf);
}
// `Symbol.prototype[@@toStringTag]` property
// https://tc39.github.io/ecma262/#sec-symbol.prototype-@@tostringtag
setToStringTag($Symbol, SYMBOL);

hiddenKeys[HIDDEN] = true;


/***/ }),

/***/ "HYrn":
/***/ (function(module, exports) {

var id = 0;
var postfix = Math.random();

module.exports = function (key) {
  return 'Symbol(' + String(key === undefined ? '' : key) + ')_' + (++id + postfix).toString(36);
};


/***/ }),

/***/ "HovQ":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = window.oa && window.oa.domain ? window.oa.domain : 'openagenda.com';

/***/ }),

/***/ "I2Za":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("yHq5");

/***/ }),

/***/ "I9Ws":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("yCXr");
__webpack_require__("b/Jy");
__webpack_require__("qCBb");
__webpack_require__("A4uS");
__webpack_require__("+r8s");
// TODO: Remove from `core-js@4`
__webpack_require__("25Hm");

module.exports = parent;


/***/ }),

/***/ "IKC6":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("xR7j");
var entryVirtual = __webpack_require__("Gfq3");

module.exports = entryVirtual('Array').reduce;


/***/ }),

/***/ "IRf+":
/***/ (function(module, exports, __webpack_require__) {

var aFunction = __webpack_require__("hpdy");

// optional / simple context binding
module.exports = function (fn, that, length) {
  aFunction(fn);
  if (that === undefined) return fn;
  switch (length) {
    case 0: return function () {
      return fn.call(that);
    };
    case 1: return function (a) {
      return fn.call(that, a);
    };
    case 2: return function (a, b) {
      return fn.call(that, a, b);
    };
    case 3: return function (a, b, c) {
      return fn.call(that, a, b, c);
    };
  }
  return function (/* ...args */) {
    return fn.apply(that, arguments);
  };
};


/***/ }),

/***/ "JAL5":
/***/ (function(module, exports) {

exports.f = Object.getOwnPropertySymbols;


/***/ }),

/***/ "JChK":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("mm5/");

module.exports = parent;


/***/ }),

/***/ "JCy+":
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__("XU0c");

var replacement = /#|\.prototype\./;

var isForced = function (feature, detection) {
  var value = data[normalize(feature)];
  return value == POLYFILL ? true
    : value == NATIVE ? false
    : typeof detection == 'function' ? fails(detection)
    : !!detection;
};

var normalize = isForced.normalize = function (string) {
  return String(string).replace(replacement, '.').toLowerCase();
};

var data = isForced.data = {};
var NATIVE = isForced.NATIVE = 'N';
var POLYFILL = isForced.POLYFILL = 'P';

module.exports = isForced;


/***/ }),

/***/ "JliG":
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__("5Jdw");
var IE8_DOM_DEFINE = __webpack_require__("64g+");
var anObject = __webpack_require__("LTNl");
var toPrimitive = __webpack_require__("3Mt6");

var nativeDefineProperty = Object.defineProperty;

// `Object.defineProperty` method
// https://tc39.github.io/ecma262/#sec-object.defineproperty
exports.f = DESCRIPTORS ? nativeDefineProperty : function defineProperty(O, P, Attributes) {
  anObject(O);
  P = toPrimitive(P, true);
  anObject(Attributes);
  if (IE8_DOM_DEFINE) try {
    return nativeDefineProperty(O, P, Attributes);
  } catch (error) { /* empty */ }
  if ('get' in Attributes || 'set' in Attributes) throw TypeError('Accessors not supported');
  if ('value' in Attributes) O[P] = Attributes.value;
  return O;
};


/***/ }),

/***/ "Ju9p":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("Pypn");

module.exports = parent;


/***/ }),

/***/ "K1lx":
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__("n9AK");
var setPrototypeOf = __webpack_require__("wXON");

// `Object.setPrototypeOf` method
// https://tc39.github.io/ecma262/#sec-object.setprototypeof
$({ target: 'Object', stat: true }, {
  setPrototypeOf: setPrototypeOf
});


/***/ }),

/***/ "K1oV":
/***/ (function(module, exports, __webpack_require__) {

var has = __webpack_require__("zNvU");
var toObject = __webpack_require__("quhl");
var sharedKey = __webpack_require__("iDMO");
var CORRECT_PROTOTYPE_GETTER = __webpack_require__("KEoK");

var IE_PROTO = sharedKey('IE_PROTO');
var ObjectPrototype = Object.prototype;

// `Object.getPrototypeOf` method
// https://tc39.github.io/ecma262/#sec-object.getprototypeof
module.exports = CORRECT_PROTOTYPE_GETTER ? Object.getPrototypeOf : function (O) {
  O = toObject(O);
  if (has(O, IE_PROTO)) return O[IE_PROTO];
  if (typeof O.constructor == 'function' && O instanceof O.constructor) {
    return O.constructor.prototype;
  } return O instanceof Object ? ObjectPrototype : null;
};


/***/ }),

/***/ "K50e":
/***/ (function(module, exports, __webpack_require__) {

var some = __webpack_require__("xoPw");

var ArrayPrototype = Array.prototype;

module.exports = function (it) {
  var own = it.some;
  return it === ArrayPrototype || (it instanceof Array && own === ArrayPrototype.some) ? some : own;
};


/***/ }),

/***/ "KEoK":
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__("XU0c");

module.exports = !fails(function () {
  function F() { /* empty */ }
  F.prototype.constructor = null;
  return Object.getPrototypeOf(new F()) !== F.prototype;
});


/***/ }),

/***/ "KT41":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var domain = __webpack_require__("HovQ");

var loadJs = __webpack_require__("kEgS"),
    cn = __webpack_require__("ycY6"),
    defaults = {
  all: {
    controllersPath: '//' + domain + '/js/embed/cibulControllers.js'
  },
  dev: {
    controllersPath: '//d.openagenda.com/js/embed/cibulControllers.js'
  },
  tpl: {
    controllersPath: '/js/browserified/widgetsControllerMain.js'
  }
},
    env = window.env ? window.env : 'production',
    params = cn.extend(defaults.all, defaults[env] ? defaults[env] : {});

module.exports = function (cb) {
  getRegister(cb);
};

var getRegister = function getRegister(cb) {
  if (window.cibul) {
    cb(window.cibul.registerWidget);
  } else {
    loadJs(params.controllersPath, function () {
      cb(window.cibul.registerWidget);
    });
  }
};

/***/ }),

/***/ "KW2q":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.species` well-known symbol
// https://tc39.github.io/ecma262/#sec-symbol.species
defineWellKnownSymbol('species');


/***/ }),

/***/ "KqXw":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("ax0f");
var exec = __webpack_require__("QsUS");

$({ target: 'RegExp', proto: true, forced: /./.exec !== exec }, {
  exec: exec
});


/***/ }),

/***/ "L0Na":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("B4Ad");

/***/ }),

/***/ "L1sM":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("AYji");
var entryVirtual = __webpack_require__("Gfq3");

module.exports = entryVirtual('String').trim;


/***/ }),

/***/ "L2rT":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var fails = __webpack_require__("ct80");

// babel-minify transpiles RegExp('a', 'y') -> /a/y and it causes SyntaxError,
// so we use an intermediate function.
function RE(s, f) {
  return RegExp(s, f);
}

exports.UNSUPPORTED_Y = fails(function () {
  // babel-minify transpiles RegExp('a', 'y') -> /a/y and it causes SyntaxError
  var re = RE('a', 'y');
  re.lastIndex = 2;
  return re.exec('abcd') != null;
});

exports.BROKEN_CARET = fails(function () {
  // https://bugzilla.mozilla.org/show_bug.cgi?id=773687
  var re = RE('^r', 'gy');
  re.lastIndex = 2;
  return re.exec('str') != null;
});


/***/ }),

/***/ "LTNl":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("H3h0");

module.exports = function (it) {
  if (!isObject(it)) {
    throw TypeError(String(it) + ' is not an object');
  } return it;
};


/***/ }),

/***/ "LTnH":
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__("lWVH");
var requireObjectCoercible = __webpack_require__("j0cD");

// `String.prototype.{ codePointAt, at }` methods implementation
var createMethod = function (CONVERT_TO_STRING) {
  return function ($this, pos) {
    var S = String(requireObjectCoercible($this));
    var position = toInteger(pos);
    var size = S.length;
    var first, second;
    if (position < 0 || position >= size) return CONVERT_TO_STRING ? '' : undefined;
    first = S.charCodeAt(position);
    return first < 0xD800 || first > 0xDBFF || position + 1 === size
      || (second = S.charCodeAt(position + 1)) < 0xDC00 || second > 0xDFFF
        ? CONVERT_TO_STRING ? S.charAt(position) : first
        : CONVERT_TO_STRING ? S.slice(position, position + 2) : (first - 0xD800 << 10) + (second - 0xDC00) + 0x10000;
  };
};

module.exports = {
  // `String.prototype.codePointAt` method
  // https://tc39.github.io/ecma262/#sec-string.prototype.codepointat
  codeAt: createMethod(false),
  // `String.prototype.at` method
  // https://github.com/mathiasbynens/String.prototype.at
  charAt: createMethod(true)
};


/***/ }),

/***/ "LWF0":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("NeU5");

/***/ }),

/***/ "M6xr":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("eOXo");

/***/ }),

/***/ "MYsx":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("SqXu");
var path = __webpack_require__("j0PW");

module.exports = path.parseInt;


/***/ }),

/***/ "Mkvj":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("n9AK");
var $some = __webpack_require__("zDWZ").some;
var arrayMethodIsStrict = __webpack_require__("nSCK");
var arrayMethodUsesToLength = __webpack_require__("ocDp");

var STRICT_METHOD = arrayMethodIsStrict('some');
var USES_TO_LENGTH = arrayMethodUsesToLength('some');

// `Array.prototype.some` method
// https://tc39.github.io/ecma262/#sec-array.prototype.some
$({ target: 'Array', proto: true, forced: !STRICT_METHOD || !USES_TO_LENGTH }, {
  some: function some(callbackfn /* , thisArg */) {
    return $some(this, callbackfn, arguments.length > 1 ? arguments[1] : undefined);
  }
});


/***/ }),

/***/ "MvUL":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var fixRegExpWellKnownSymbolLogic = __webpack_require__("lbJE");
var anObject = __webpack_require__("FXyv");
var toObject = __webpack_require__("N9G2");
var toLength = __webpack_require__("tJVe");
var toInteger = __webpack_require__("i7Kn");
var requireObjectCoercible = __webpack_require__("cww3");
var advanceStringIndex = __webpack_require__("4/YM");
var regExpExec = __webpack_require__("34wW");

var max = Math.max;
var min = Math.min;
var floor = Math.floor;
var SUBSTITUTION_SYMBOLS = /\$([$&'`]|\d\d?|<[^>]*>)/g;
var SUBSTITUTION_SYMBOLS_NO_NAMED = /\$([$&'`]|\d\d?)/g;

var maybeToString = function (it) {
  return it === undefined ? it : String(it);
};

// @@replace logic
fixRegExpWellKnownSymbolLogic('replace', 2, function (REPLACE, nativeReplace, maybeCallNative, reason) {
  var REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE = reason.REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE;
  var REPLACE_KEEPS_$0 = reason.REPLACE_KEEPS_$0;
  var UNSAFE_SUBSTITUTE = REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE ? '$' : '$0';

  return [
    // `String.prototype.replace` method
    // https://tc39.github.io/ecma262/#sec-string.prototype.replace
    function replace(searchValue, replaceValue) {
      var O = requireObjectCoercible(this);
      var replacer = searchValue == undefined ? undefined : searchValue[REPLACE];
      return replacer !== undefined
        ? replacer.call(searchValue, O, replaceValue)
        : nativeReplace.call(String(O), searchValue, replaceValue);
    },
    // `RegExp.prototype[@@replace]` method
    // https://tc39.github.io/ecma262/#sec-regexp.prototype-@@replace
    function (regexp, replaceValue) {
      if (
        (!REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE && REPLACE_KEEPS_$0) ||
        (typeof replaceValue === 'string' && replaceValue.indexOf(UNSAFE_SUBSTITUTE) === -1)
      ) {
        var res = maybeCallNative(nativeReplace, regexp, this, replaceValue);
        if (res.done) return res.value;
      }

      var rx = anObject(regexp);
      var S = String(this);

      var functionalReplace = typeof replaceValue === 'function';
      if (!functionalReplace) replaceValue = String(replaceValue);

      var global = rx.global;
      if (global) {
        var fullUnicode = rx.unicode;
        rx.lastIndex = 0;
      }
      var results = [];
      while (true) {
        var result = regExpExec(rx, S);
        if (result === null) break;

        results.push(result);
        if (!global) break;

        var matchStr = String(result[0]);
        if (matchStr === '') rx.lastIndex = advanceStringIndex(S, toLength(rx.lastIndex), fullUnicode);
      }

      var accumulatedResult = '';
      var nextSourcePosition = 0;
      for (var i = 0; i < results.length; i++) {
        result = results[i];

        var matched = String(result[0]);
        var position = max(min(toInteger(result.index), S.length), 0);
        var captures = [];
        // NOTE: This is equivalent to
        //   captures = result.slice(1).map(maybeToString)
        // but for some reason `nativeSlice.call(result, 1, result.length)` (called in
        // the slice polyfill when slicing native arrays) "doesn't work" in safari 9 and
        // causes a crash (https://pastebin.com/N21QzeQA) when trying to debug it.
        for (var j = 1; j < result.length; j++) captures.push(maybeToString(result[j]));
        var namedCaptures = result.groups;
        if (functionalReplace) {
          var replacerArgs = [matched].concat(captures, position, S);
          if (namedCaptures !== undefined) replacerArgs.push(namedCaptures);
          var replacement = String(replaceValue.apply(undefined, replacerArgs));
        } else {
          replacement = getSubstitution(matched, S, position, captures, namedCaptures, replaceValue);
        }
        if (position >= nextSourcePosition) {
          accumulatedResult += S.slice(nextSourcePosition, position) + replacement;
          nextSourcePosition = position + matched.length;
        }
      }
      return accumulatedResult + S.slice(nextSourcePosition);
    }
  ];

  // https://tc39.github.io/ecma262/#sec-getsubstitution
  function getSubstitution(matched, str, position, captures, namedCaptures, replacement) {
    var tailPos = position + matched.length;
    var m = captures.length;
    var symbols = SUBSTITUTION_SYMBOLS_NO_NAMED;
    if (namedCaptures !== undefined) {
      namedCaptures = toObject(namedCaptures);
      symbols = SUBSTITUTION_SYMBOLS;
    }
    return nativeReplace.call(replacement, symbols, function (match, ch) {
      var capture;
      switch (ch.charAt(0)) {
        case '$': return '$';
        case '&': return matched;
        case '`': return str.slice(0, position);
        case "'": return str.slice(tailPos);
        case '<':
          capture = namedCaptures[ch.slice(1, -1)];
          break;
        default: // \d\d?
          var n = +ch;
          if (n === 0) return match;
          if (n > m) {
            var f = floor(n / 10);
            if (f === 0) return match;
            if (f <= m) return captures[f - 1] === undefined ? ch.charAt(1) : captures[f - 1] + ch.charAt(1);
            return match;
          }
          capture = captures[n - 1];
      }
      return capture === undefined ? '' : capture;
    });
  }
});


/***/ }),

/***/ "MyxS":
/***/ (function(module, exports, __webpack_require__) {

var shared = __webpack_require__("TN3B");
var uid = __webpack_require__("HYrn");

var keys = shared('keys');

module.exports = function (key) {
  return keys[key] || (keys[key] = uid(key));
};


/***/ }),

/***/ "N+gJ":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.search` well-known symbol
// https://tc39.github.io/ecma262/#sec-symbol.search
defineWellKnownSymbol('search');


/***/ }),

/***/ "N4z3":
/***/ (function(module, exports, __webpack_require__) {

// toObject with fallback for non-array-like ES3 strings
var IndexedObject = __webpack_require__("g6a+");
var requireObjectCoercible = __webpack_require__("cww3");

module.exports = function (it) {
  return IndexedObject(requireObjectCoercible(it));
};


/***/ }),

/***/ "N9G2":
/***/ (function(module, exports, __webpack_require__) {

var requireObjectCoercible = __webpack_require__("cww3");

// `ToObject` abstract operation
// https://tc39.github.io/ecma262/#sec-toobject
module.exports = function (argument) {
  return Object(requireObjectCoercible(argument));
};


/***/ }),

/***/ "NOtv":
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(process) {

__webpack_require__("1t7P");

__webpack_require__("jQ/y");

__webpack_require__("7x/C");

__webpack_require__("iKE+");

__webpack_require__("KqXw");

__webpack_require__("DZ+c");

__webpack_require__("WNMA");

__webpack_require__("MvUL");

var _JSON$stringify = __webpack_require__("AP/O");

var _spliceInstanceProperty = __webpack_require__("L0Na");

var _parseInt = __webpack_require__("I2Za");

var _Symbol$iterator = __webpack_require__("n1Zv");

var _typeof2 = __webpack_require__("p853");

var _Symbol = __webpack_require__("s3Nl");

function _typeof(obj) {
  if (typeof _Symbol === "function" && _typeof2(_Symbol$iterator) === "symbol") {
    _typeof = function _typeof(obj) {
      return _typeof2(obj);
    };
  } else {
    _typeof = function _typeof(obj) {
      return obj && typeof _Symbol === "function" && obj.constructor === _Symbol && obj !== _Symbol.prototype ? "symbol" : _typeof2(obj);
    };
  }

  return _typeof(obj);
}
/* eslint-env browser */

/**
 * This is the web browser implementation of `debug()`.
 */


exports.log = log;
exports.formatArgs = formatArgs;
exports.save = save;
exports.load = load;
exports.useColors = useColors;
exports.storage = localstorage();
/**
 * Colors.
 */

exports.colors = ['#0000CC', '#0000FF', '#0033CC', '#0033FF', '#0066CC', '#0066FF', '#0099CC', '#0099FF', '#00CC00', '#00CC33', '#00CC66', '#00CC99', '#00CCCC', '#00CCFF', '#3300CC', '#3300FF', '#3333CC', '#3333FF', '#3366CC', '#3366FF', '#3399CC', '#3399FF', '#33CC00', '#33CC33', '#33CC66', '#33CC99', '#33CCCC', '#33CCFF', '#6600CC', '#6600FF', '#6633CC', '#6633FF', '#66CC00', '#66CC33', '#9900CC', '#9900FF', '#9933CC', '#9933FF', '#99CC00', '#99CC33', '#CC0000', '#CC0033', '#CC0066', '#CC0099', '#CC00CC', '#CC00FF', '#CC3300', '#CC3333', '#CC3366', '#CC3399', '#CC33CC', '#CC33FF', '#CC6600', '#CC6633', '#CC9900', '#CC9933', '#CCCC00', '#CCCC33', '#FF0000', '#FF0033', '#FF0066', '#FF0099', '#FF00CC', '#FF00FF', '#FF3300', '#FF3333', '#FF3366', '#FF3399', '#FF33CC', '#FF33FF', '#FF6600', '#FF6633', '#FF9900', '#FF9933', '#FFCC00', '#FFCC33'];
/**
 * Currently only WebKit-based Web Inspectors, Firefox >= v31,
 * and the Firebug extension (any Firefox version) are known
 * to support "%c" CSS customizations.
 *
 * TODO: add a `localStorage` variable to explicitly enable/disable colors
 */
// eslint-disable-next-line complexity

function useColors() {
  // NB: In an Electron preload script, document will be defined but not fully
  // initialized. Since we know we're in Chrome, we'll just detect this case
  // explicitly
  if (typeof window !== 'undefined' && window.process && (window.process.type === 'renderer' || window.process.__nwjs)) {
    return true;
  } // Internet Explorer and Edge do not support colors.


  if (typeof navigator !== 'undefined' && navigator.userAgent && navigator.userAgent.toLowerCase().match(/(edge|trident)\/(\d+)/)) {
    return false;
  } // Is webkit? http://stackoverflow.com/a/16459606/376773
  // document is undefined in react-native: https://github.com/facebook/react-native/pull/1632


  return typeof document !== 'undefined' && document.documentElement && document.documentElement.style && document.documentElement.style.WebkitAppearance || // Is firebug? http://stackoverflow.com/a/398120/376773
  typeof window !== 'undefined' && window.console && (window.console.firebug || window.console.exception && window.console.table) || // Is firefox >= v31?
  // https://developer.mozilla.org/en-US/docs/Tools/Web_Console#Styling_messages
  typeof navigator !== 'undefined' && navigator.userAgent && navigator.userAgent.toLowerCase().match(/firefox\/(\d+)/) && _parseInt(RegExp.$1, 10) >= 31 || // Double check webkit in userAgent just in case we are in a worker
  typeof navigator !== 'undefined' && navigator.userAgent && navigator.userAgent.toLowerCase().match(/applewebkit\/(\d+)/);
}
/**
 * Colorize log arguments if enabled.
 *
 * @api public
 */


function formatArgs(args) {
  args[0] = (this.useColors ? '%c' : '') + this.namespace + (this.useColors ? ' %c' : ' ') + args[0] + (this.useColors ? '%c ' : ' ') + '+' + module.exports.humanize(this.diff);

  if (!this.useColors) {
    return;
  }

  var c = 'color: ' + this.color;

  _spliceInstanceProperty(args).call(args, 1, 0, c, 'color: inherit'); // The final "%c" is somewhat tricky, because there could be other
  // arguments passed either before or after the %c, so we need to
  // figure out the correct index to insert the CSS into


  var index = 0;
  var lastC = 0;
  args[0].replace(/%[a-zA-Z%]/g, function (match) {
    if (match === '%%') {
      return;
    }

    index++;

    if (match === '%c') {
      // We only are interested in the *last* %c
      // (the user may have provided their own)
      lastC = index;
    }
  });

  _spliceInstanceProperty(args).call(args, lastC, 0, c);
}
/**
 * Invokes `console.log()` when available.
 * No-op when `console.log` is not a "function".
 *
 * @api public
 */


function log() {
  var _console; // This hackery is required for IE8/9, where
  // the `console.log` function doesn't have 'apply'


  return (typeof console === "undefined" ? "undefined" : _typeof(console)) === 'object' && console.log && (_console = console).log.apply(_console, arguments);
}
/**
 * Save `namespaces`.
 *
 * @param {String} namespaces
 * @api private
 */


function save(namespaces) {
  try {
    if (namespaces) {
      exports.storage.setItem('debug', namespaces);
    } else {
      exports.storage.removeItem('debug');
    }
  } catch (error) {// Swallow
    // XXX (@Qix-) should we be logging these?
  }
}
/**
 * Load `namespaces`.
 *
 * @return {String} returns the previously persisted debug modes
 * @api private
 */


function load() {
  var r;

  try {
    r = exports.storage.getItem('debug');
  } catch (error) {} // Swallow
  // XXX (@Qix-) should we be logging these?
  // If debug isn't set in LS, and we're in Electron, try to load $DEBUG


  if (!r && typeof process !== 'undefined' && 'env' in process) {
    r = process.env.DEBUG;
  }

  return r;
}
/**
 * Localstorage attempts to return the localstorage.
 *
 * This is necessary because safari throws
 * when a user disables cookies/localstorage
 * and you attempt to access it.
 *
 * @return {LocalStorage}
 * @api private
 */


function localstorage() {
  try {
    // TVMLKit (Apple TV JS Runtime) does not have a window object, just localStorage in the global context
    // The Browser also has localStorage in the global context.
    return localStorage;
  } catch (error) {// Swallow
    // XXX (@Qix-) should we be logging these?
  }
}

module.exports = __webpack_require__("3JDX")(exports);
var formatters = module.exports.formatters;
/**
 * Map %j to `JSON.stringify()`, since no Web Inspectors do that by default.
 */

formatters.j = function (v) {
  try {
    return _JSON$stringify(v);
  } catch (error) {
    return '[UnexpectedJSONParseError]: ' + error.message;
  }
};
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__("F63i")))

/***/ }),

/***/ "NSkT":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("kXRz");

module.exports = parent;


/***/ }),

/***/ "NXqE":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("KqXw");

__webpack_require__("Ysgh");

var _setTimeout = __webpack_require__("yC+K");

var _forEachInstanceProperty = __webpack_require__("i6Tr");

var du = __webpack_require__("aDtO"),
    utils = __webpack_require__("QkVY"),
    log = __webpack_require__("NOtv")('widgetLib');
/**
 * for each element corresponding to selector, load config in attribute
 * and handover the element and the config to the callback
 * callback should be the widget
 */


exports.forEachAnchor = function (selector, options, cb) {
  // do it asap
  _onAsapReady(_load(selector, options, cb)); // at latest, do it if dom is ready


  _domReady(_load(selector, options, cb));
};

function _load(selector, options, cb) {
  return function () {
    var found = false,
        _process = function _process(elem) {
      found = true;

      if (!_flagged(elem)) {
        cb(elem, utils.extend({
          anchorConfig: readAnchorConfig(elem)
        }, options));
      }
    };

    _forEachInstanceProperty(du).call(du, du.els(selector), _process); // if class has not been found, attempt to find through backup data attribute selector


    if (!found && options.backup) {
      _forEachInstanceProperty(du).call(du, document.querySelectorAll(options.backup.selector), function (elem) {
        if (options.backup && options.backup.classNames) {
          du.addClass(elem, options.backup.classNames);
        }

        _process(elem);
      });
    }
  };
}
/**
 * bootstrap widget with default controller interface functions
 */


exports.interface = function (name, uid, cbs) {
  return utils.extend({
    name: name,
    uid: uid,
    clear: isNotDefined('clear', name),
    include: isNotDefined('include', name),
    enable: isNotDefined('enable', name),
    disable: isNotDefined('disable', name),
    change: isNotDefined('change', name)
  }, cbs);
};

function _flagged(elem) {
  if (elem.hasAttribute('data-flag')) {
    return true;
  }

  elem.setAttribute('data-flag', '1');
  return false;
}

function isNotDefined(type, name) {
  return function () {};
}

function readAnchorConfig(elem) {
  if (elem.hasAttribute('data-cbctl')) {
    return elem.getAttribute('data-cbctl').split('|');
  } else if (elem.hasAttribute('src')) {
    return [elem.getAttribute('src')];
  }
}

function _domReady(cb) {
  if (document.readyState === "complete") {
    cb();
  } else {
    du.addEvent(window, 'load', cb);
  }
}

function _onAsapReady(timeout, cb) {
  if (arguments.length == 1) {
    cb = timeout;
    timeout = 0;
  }

  if (du.el('body')) return cb();

  _setTimeout(function () {
    _onAsapReady(Math.max((timeout + 10) * 2, 10000), cb);
  }, timeout);
}

/***/ }),

/***/ "NeU5":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("Fu/f");

module.exports = parent;


/***/ }),

/***/ "Nj2W":
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__("lWVH");

var max = Math.max;
var min = Math.min;

// Helper for a popular repeating case of the spec:
// Let integer be ? ToInteger(index).
// If integer < 0, let result be max((length + integer), 0); else let result be min(integer, length).
module.exports = function (index, length) {
  var integer = toInteger(index);
  return integer < 0 ? max(integer + length, 0) : min(integer, length);
};


/***/ }),

/***/ "OI5d":
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__("n9AK");
var DESCRIPTORS = __webpack_require__("5Jdw");
var objectDefinePropertyModile = __webpack_require__("JliG");

// `Object.defineProperty` method
// https://tc39.github.io/ecma262/#sec-object.defineproperty
$({ target: 'Object', stat: true, forced: !DESCRIPTORS, sham: !DESCRIPTORS }, {
  defineProperty: objectDefinePropertyModile.f
});


/***/ }),

/***/ "OcM9":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.split` well-known symbol
// https://tc39.github.io/ecma262/#sec-symbol.split
defineWellKnownSymbol('split');


/***/ }),

/***/ "PBoD":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("tTj0");

/***/ }),

/***/ "PLru":
/***/ (function(module, exports, __webpack_require__) {

var IS_PURE = __webpack_require__("Vl7J");
var store = __webpack_require__("yULr");

(module.exports = function (key, value) {
  return store[key] || (store[key] = value !== undefined ? value : {});
})('versions', []).push({
  version: '3.6.4',
  mode: IS_PURE ? 'pure' : 'global',
  copyright: '© 2020 Denis Pushkarev (zloirock.ru)'
});


/***/ }),

/***/ "POz8":
/***/ (function(module, exports, __webpack_require__) {

var wellKnownSymbol = __webpack_require__("fVMg");

var TO_STRING_TAG = wellKnownSymbol('toStringTag');
var test = {};

test[TO_STRING_TAG] = 'z';

module.exports = String(test) === '[object z]';


/***/ }),

/***/ "PjRa":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("9JhN");
var createNonEnumerableProperty = __webpack_require__("WxKw");

module.exports = function (key, value) {
  try {
    createNonEnumerableProperty(global, key, value);
  } catch (error) {
    global[key] = value;
  } return value;
};


/***/ }),

/***/ "PjZX":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("9JhN");

module.exports = global;


/***/ }),

/***/ "PrcH":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.replace` well-known symbol
// https://tc39.github.io/ecma262/#sec-symbol.replace
defineWellKnownSymbol('replace');


/***/ }),

/***/ "Pypn":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("OI5d");
var path = __webpack_require__("j0PW");

var Object = path.Object;

var defineProperty = module.exports = function defineProperty(it, key, desc) {
  return Object.defineProperty(it, key, desc);
};

if (Object.defineProperty.sham) defineProperty.sham = true;


/***/ }),

/***/ "Q+0L":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("lv3h");
var entryVirtual = __webpack_require__("Gfq3");

module.exports = entryVirtual('Array').keys;


/***/ }),

/***/ "QG4m":
/***/ (function(module, exports, __webpack_require__) {

var _Symbol$iterator = __webpack_require__("WVwf");

var _Symbol = __webpack_require__("pzYf");

function _typeof(obj) {
  "@babel/helpers - typeof";

  if (typeof _Symbol === "function" && typeof _Symbol$iterator === "symbol") {
    module.exports = _typeof = function _typeof(obj) {
      return typeof obj;
    };
  } else {
    module.exports = _typeof = function _typeof(obj) {
      return obj && typeof _Symbol === "function" && obj.constructor === _Symbol && obj !== _Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}

module.exports = _typeof;

/***/ }),

/***/ "Qb90":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("oNh+");
var userAgent = __webpack_require__("9eyx");

var process = global.process;
var versions = process && process.versions;
var v8 = versions && versions.v8;
var match, version;

if (v8) {
  match = v8.split('.');
  version = match[0] + match[1];
} else if (userAgent) {
  match = userAgent.match(/Edge\/(\d+)/);
  if (!match || match[1] >= 74) {
    match = userAgent.match(/Chrome\/(\d+)/);
    if (match) version = match[1];
  }
}

module.exports = version && +version;


/***/ }),

/***/ "QkVY":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__("7xRU");

__webpack_require__("7x/C");

__webpack_require__("iKE+");

__webpack_require__("KqXw");

__webpack_require__("DZ+c");

__webpack_require__("MvUL");

var _indexOfInstanceProperty = __webpack_require__("8G3K");

var _forEachInstanceProperty = __webpack_require__("espU");

var _typeof = __webpack_require__("wiNy");

var _sliceInstanceProperty = __webpack_require__("GBkV");

module.exports = {
  extend: extend,
  filterByAttr: filterByAttr,
  isArray: isArray,
  size: size,
  fZ: fZ,
  unique: unique,
  forEach: forEach,
  toCamelCase: toCamelCase,
  toUnderscore: toUnderscore,
  escape: escape,
  truncate: truncate,
  capitalize: capitalize,
  uncapitalize: uncapitalize,
  cleanString: cleanString,
  deep: __webpack_require__("aph7")
};

function uncapitalize(str) {
  str = String(str);
  if (!str.length) return '';
  return str[0].toLowerCase() + str.substr(1, str.length);
}

function capitalize(str) {
  str = String(str);
  if (!str.length) return '';
  return str[0].toUpperCase() + str.substr(1, str.length);
}

;

function truncate(str, len, append) {
  str = String(str);

  if (str.length > len) {
    str = _sliceInstanceProperty(str).call(str, 0, len);
    if (append) str += append;
  }

  return str;
}

function escape(str, escapeApostrophe) {
  if (!str) return str;

  if (escapeApostrophe === undefined) {
    escapeApostrophe = true;
  }

  var escaped = String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');

  if (escapeApostrophe) {
    escaped = escaped.replace(/'/g, '&#39;');
  }

  return escaped;
}

function toCamelCase(input) {
  if (_typeof(input) == 'object') {
    var camelCased = {};

    for (var key in input) {
      camelCased[toCamelCase(key)] = input[key];
    }

    return camelCased;
  }

  return input.replace(/[-_](.)/g, function (match, group1) {
    return group1.toUpperCase();
  });
}

function toUnderscore(input) {
  if (_typeof(input) == 'object') {
    var underscored = {};

    for (var key in input) {
      underscored[toUnderscore(key)] = input[key];
    }

    return underscored;
  }

  return input.replace(/([A-Z])/g, function ($1) {
    return "_" + $1.toLowerCase();
  });
}

function unique(arr) {
  var u = [];

  _forEachInstanceProperty(arr).call(arr, function (a) {
    if (_indexOfInstanceProperty(u).call(u, a) === -1) u.push(a);
  });

  return u;
}

function isArray(obj) {
  return Object.prototype.toString.call(obj) === '[object Array]';
}

function size(obj) {
  var size = 0,
      key;

  for (key in obj) {
    if (obj.hasOwnProperty(key)) size++;
  }

  return size;
}

function filterByAttr(obj, arr) {
  var newObj = {};
  forEach(arr, function (name) {
    if (obj[name] !== undefined) newObj[name] = obj[name];
  });
  return newObj;
}

;

function forEach(array, action) {
  for (var i = 0; i < array.length; i++) {
    action(array[i]);
  }
}

;

function extend() {
  for (var i = 1; i < arguments.length; i++) {
    for (var key in arguments[i]) {
      if (arguments[i].hasOwnProperty(key)) {
        arguments[0][key] = arguments[i][key];
      }
    }
  }

  return arguments[0];
}

function fZ(n, size) {
  if (!size) size = 2;
  var s = n + '',
      sign = s.substr(0, 1) == '-' ? '-' : '';

  if (sign.length) {
    s = s.substr(1);
  }

  while (s.length < size) {
    s = '0' + s;
  }

  return sign + s;
}

function cleanString(str) {
  if (typeof str !== 'string') return str;
  var charsToClean = [1, 2, 3, 4, 5, 6, 7, 8, 11, // VT
  12, // form feed - https://www.compart.com/en/unicode/U+000C
  15, // shift in
  18, // DC2
  19, // DC3
  21, // NAK
  24, // Cancel
  26, // SUB
  27, // Esc
  28, // File separator
  29, // GS group separator
  30, // RS
  31, // Information separator
  8232, 8233, 769 // U+0301
  ];

  for (var i = 0; i < charsToClean.length; i++) {
    charsToClean[i] = String.fromCharCode(charsToClean[i]);
  }

  return str.replace(new RegExp('[' + charsToClean.join('') + ']', 'g'), ' ');
}

/***/ }),

/***/ "Qqkl":
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__("n9AK");
var toObject = __webpack_require__("quhl");
var nativeKeys = __webpack_require__("nKVx");
var fails = __webpack_require__("XU0c");

var FAILS_ON_PRIMITIVES = fails(function () { nativeKeys(1); });

// `Object.keys` method
// https://tc39.github.io/ecma262/#sec-object.keys
$({ target: 'Object', stat: true, forced: FAILS_ON_PRIMITIVES }, {
  keys: function keys(it) {
    return nativeKeys(toObject(it));
  }
});


/***/ }),

/***/ "QsUS":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var regexpFlags = __webpack_require__("q/0V");
var stickyHelpers = __webpack_require__("L2rT");

var nativeExec = RegExp.prototype.exec;
// This always refers to the native implementation, because the
// String#replace polyfill uses ./fix-regexp-well-known-symbol-logic.js,
// which loads this file before patching the method.
var nativeReplace = String.prototype.replace;

var patchedExec = nativeExec;

var UPDATES_LAST_INDEX_WRONG = (function () {
  var re1 = /a/;
  var re2 = /b*/g;
  nativeExec.call(re1, 'a');
  nativeExec.call(re2, 'a');
  return re1.lastIndex !== 0 || re2.lastIndex !== 0;
})();

var UNSUPPORTED_Y = stickyHelpers.UNSUPPORTED_Y || stickyHelpers.BROKEN_CARET;

// nonparticipating capturing group, copied from es5-shim's String#split patch.
var NPCG_INCLUDED = /()??/.exec('')[1] !== undefined;

var PATCH = UPDATES_LAST_INDEX_WRONG || NPCG_INCLUDED || UNSUPPORTED_Y;

if (PATCH) {
  patchedExec = function exec(str) {
    var re = this;
    var lastIndex, reCopy, match, i;
    var sticky = UNSUPPORTED_Y && re.sticky;
    var flags = regexpFlags.call(re);
    var source = re.source;
    var charsAdded = 0;
    var strCopy = str;

    if (sticky) {
      flags = flags.replace('y', '');
      if (flags.indexOf('g') === -1) {
        flags += 'g';
      }

      strCopy = String(str).slice(re.lastIndex);
      // Support anchored sticky behavior.
      if (re.lastIndex > 0 && (!re.multiline || re.multiline && str[re.lastIndex - 1] !== '\n')) {
        source = '(?: ' + source + ')';
        strCopy = ' ' + strCopy;
        charsAdded++;
      }
      // ^(? + rx + ) is needed, in combination with some str slicing, to
      // simulate the 'y' flag.
      reCopy = new RegExp('^(?:' + source + ')', flags);
    }

    if (NPCG_INCLUDED) {
      reCopy = new RegExp('^' + source + '$(?!\\s)', flags);
    }
    if (UPDATES_LAST_INDEX_WRONG) lastIndex = re.lastIndex;

    match = nativeExec.call(sticky ? reCopy : re, strCopy);

    if (sticky) {
      if (match) {
        match.input = match.input.slice(charsAdded);
        match[0] = match[0].slice(charsAdded);
        match.index = re.lastIndex;
        re.lastIndex += match[0].length;
      } else re.lastIndex = 0;
    } else if (UPDATES_LAST_INDEX_WRONG && match) {
      re.lastIndex = re.global ? match.index + match[0].length : lastIndex;
    }
    if (NPCG_INCLUDED && match && match.length > 1) {
      // Fix browsers whose `exec` methods don't consistently return `undefined`
      // for NPCG, like IE8. NOTE: This doesn' work for /(.?)?/
      nativeReplace.call(match[0], reCopy, function () {
        for (i = 1; i < arguments.length - 2; i++) {
          if (arguments[i] === undefined) match[i] = undefined;
        }
      });
    }

    return match;
  };
}

module.exports = patchedExec;


/***/ }),

/***/ "Qzre":
/***/ (function(module, exports, __webpack_require__) {

var anObject = __webpack_require__("FXyv");
var aFunction = __webpack_require__("hpdy");
var wellKnownSymbol = __webpack_require__("fVMg");

var SPECIES = wellKnownSymbol('species');

// `SpeciesConstructor` abstract operation
// https://tc39.github.io/ecma262/#sec-speciesconstructor
module.exports = function (O, defaultConstructor) {
  var C = anObject(O).constructor;
  var S;
  return C === undefined || (S = anObject(C)[SPECIES]) == undefined ? defaultConstructor : aFunction(S);
};


/***/ }),

/***/ "R5XV":
/***/ (function(module, exports, __webpack_require__) {

var getBuiltIn = __webpack_require__("wF8L");

module.exports = getBuiltIn('document', 'documentElement');


/***/ }),

/***/ "RW1Z":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("Ju9p");

/***/ }),

/***/ "RkMe":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("X85A");

/***/ }),

/***/ "S42S":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return parseDateTimeSkeleton; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return convertNumberSkeletonToNumberFormatOptions; });
/* harmony import */ var core_js_modules_es_regexp_exec__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("KqXw");
/* harmony import */ var core_js_modules_es_regexp_exec__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_exec__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_string_replace__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("MvUL");
/* harmony import */ var core_js_modules_es_string_replace__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_replace__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_corejs3_core_js_instance_reduce__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("XSsT");
/* harmony import */ var _babel_runtime_corejs3_core_js_instance_reduce__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_instance_reduce__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_corejs3_core_js_object_assign__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("kpPl");
/* harmony import */ var _babel_runtime_corejs3_core_js_object_assign__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_corejs3_core_js_object_assign__WEBPACK_IMPORTED_MODULE_3__);





var __assign = undefined && undefined.__assign || function () {
  __assign = _babel_runtime_corejs3_core_js_object_assign__WEBPACK_IMPORTED_MODULE_3___default.a || function (t) {
    for (var s, i = 1, n = arguments.length; i < n; i++) {
      s = arguments[i];

      for (var p in s) {
        if (Object.prototype.hasOwnProperty.call(s, p)) t[p] = s[p];
      }
    }

    return t;
  };

  return __assign.apply(this, arguments);
};
/**
 * https://unicode.org/reports/tr35/tr35-dates.html#Date_Field_Symbol_Table
 * Credit: https://github.com/caridy/intl-datetimeformat-pattern/blob/master/index.js
 * with some tweaks
 */


var DATE_TIME_REGEX = /(?:[Eec]{1,6}|G{1,5}|[Qq]{1,5}|(?:[yYur]+|U{1,5})|[ML]{1,5}|d{1,2}|D{1,3}|F{1}|[abB]{1,5}|[hkHK]{1,2}|w{1,2}|W{1}|m{1,2}|s{1,2}|[zZOvVxX]{1,4})(?=([^']*'[^']*')*[^']*$)/g;
/**
 * Parse Date time skeleton into Intl.DateTimeFormatOptions
 * Ref: https://unicode.org/reports/tr35/tr35-dates.html#Date_Field_Symbol_Table
 * @public
 * @param skeleton skeleton string
 */

function parseDateTimeSkeleton(skeleton) {
  var result = {};
  skeleton.replace(DATE_TIME_REGEX, function (match) {
    var len = match.length;

    switch (match[0]) {
      // Era
      case 'G':
        result.era = len === 4 ? 'long' : len === 5 ? 'narrow' : 'short';
        break;
      // Year

      case 'y':
        result.year = len === 2 ? '2-digit' : 'numeric';
        break;

      case 'Y':
      case 'u':
      case 'U':
      case 'r':
        throw new RangeError('`Y/u/U/r` (year) patterns are not supported, use `y` instead');
      // Quarter

      case 'q':
      case 'Q':
        throw new RangeError('`q/Q` (quarter) patterns are not supported');
      // Month

      case 'M':
      case 'L':
        result.month = ['numeric', '2-digit', 'short', 'long', 'narrow'][len - 1];
        break;
      // Week

      case 'w':
      case 'W':
        throw new RangeError('`w/W` (week) patterns are not supported');

      case 'd':
        result.day = ['numeric', '2-digit'][len - 1];
        break;

      case 'D':
      case 'F':
      case 'g':
        throw new RangeError('`D/F/g` (day) patterns are not supported, use `d` instead');
      // Weekday

      case 'E':
        result.weekday = len === 4 ? 'short' : len === 5 ? 'narrow' : 'short';
        break;

      case 'e':
        if (len < 4) {
          throw new RangeError('`e..eee` (weekday) patterns are not supported');
        }

        result.weekday = ['short', 'long', 'narrow', 'short'][len - 4];
        break;

      case 'c':
        if (len < 4) {
          throw new RangeError('`c..ccc` (weekday) patterns are not supported');
        }

        result.weekday = ['short', 'long', 'narrow', 'short'][len - 4];
        break;
      // Period

      case 'a':
        // AM, PM
        result.hour12 = true;
        break;

      case 'b': // am, pm, noon, midnight

      case 'B':
        // flexible day periods
        throw new RangeError('`b/B` (period) patterns are not supported, use `a` instead');
      // Hour

      case 'h':
        result.hourCycle = 'h12';
        result.hour = ['numeric', '2-digit'][len - 1];
        break;

      case 'H':
        result.hourCycle = 'h23';
        result.hour = ['numeric', '2-digit'][len - 1];
        break;

      case 'K':
        result.hourCycle = 'h11';
        result.hour = ['numeric', '2-digit'][len - 1];
        break;

      case 'k':
        result.hourCycle = 'h24';
        result.hour = ['numeric', '2-digit'][len - 1];
        break;

      case 'j':
      case 'J':
      case 'C':
        throw new RangeError('`j/J/C` (hour) patterns are not supported, use `h/H/K/k` instead');
      // Minute

      case 'm':
        result.minute = ['numeric', '2-digit'][len - 1];
        break;
      // Second

      case 's':
        result.second = ['numeric', '2-digit'][len - 1];
        break;

      case 'S':
      case 'A':
        throw new RangeError('`S/A` (second) pattenrs are not supported, use `s` instead');
      // Zone

      case 'z':
        // 1..3, 4: specific non-location format
        result.timeZoneName = len < 4 ? 'short' : 'long';
        break;

      case 'Z': // 1..3, 4, 5: The ISO8601 varios formats

      case 'O': // 1, 4: miliseconds in day short, long

      case 'v': // 1, 4: generic non-location format

      case 'V': // 1, 2, 3, 4: time zone ID or city

      case 'X': // 1, 2, 3, 4: The ISO8601 varios formats

      case 'x':
        // 1, 2, 3, 4: The ISO8601 varios formats
        throw new RangeError('`Z/O/v/V/X/x` (timeZone) pattenrs are not supported, use `z` instead');
    }

    return '';
  });
  return result;
}

function icuUnitToEcma(unit) {
  return unit.replace(/^(.*?)-/, '');
}

var FRACTION_PRECISION_REGEX = /^\.(?:(0+)(\*)?|(#+)|(0+)(#+))$/g;
var SIGNIFICANT_PRECISION_REGEX = /^(@+)?(\+|#+)?$/g;

function parseSignificantPrecision(str) {
  var result = {};
  str.replace(SIGNIFICANT_PRECISION_REGEX, function (_, g1, g2) {
    // @@@ case
    if (typeof g2 !== 'string') {
      result.minimumSignificantDigits = g1.length;
      result.maximumSignificantDigits = g1.length;
    } // @@@+ case
    else if (g2 === '+') {
        result.minimumSignificantDigits = g1.length;
      } // .### case
      else if (g1[0] === '#') {
          result.maximumSignificantDigits = g1.length;
        } // .@@## or .@@@ case
        else {
            result.minimumSignificantDigits = g1.length;
            result.maximumSignificantDigits = g1.length + (typeof g2 === 'string' ? g2.length : 0);
          }

    return '';
  });
  return result;
}

function parseSign(str) {
  switch (str) {
    case 'sign-auto':
      return {
        signDisplay: 'auto'
      };

    case 'sign-accounting':
      return {
        currencySign: 'accounting'
      };

    case 'sign-always':
      return {
        signDisplay: 'always'
      };

    case 'sign-accounting-always':
      return {
        signDisplay: 'always',
        currencySign: 'accounting'
      };

    case 'sign-except-zero':
      return {
        signDisplay: 'exceptZero'
      };

    case 'sign-accounting-except-zero':
      return {
        signDisplay: 'exceptZero',
        currencySign: 'accounting'
      };

    case 'sign-never':
      return {
        signDisplay: 'never'
      };
  }
}

function parseNotationOptions(opt) {
  var result = {};
  var signOpts = parseSign(opt);

  if (signOpts) {
    return signOpts;
  }

  return result;
}
/**
 * https://github.com/unicode-org/icu/blob/master/docs/userguide/format_parse/numbers/skeletons.md#skeleton-stems-and-options
 */


function convertNumberSkeletonToNumberFormatOptions(tokens) {
  var _context, _context2;

  var result = {};

  for (var _i = 0, tokens_1 = tokens; _i < tokens_1.length; _i++) {
    var token = tokens_1[_i];

    switch (token.stem) {
      case 'percent':
        result.style = 'percent';
        continue;

      case 'currency':
        result.style = 'currency';
        result.currency = token.options[0];
        continue;

      case 'group-off':
        result.useGrouping = false;
        continue;

      case 'precision-integer':
      case '.':
        result.maximumFractionDigits = 0;
        continue;

      case 'measure-unit':
        result.style = 'unit';
        result.unit = icuUnitToEcma(token.options[0]);
        continue;

      case 'compact-short':
        result.notation = 'compact';
        result.compactDisplay = 'short';
        continue;

      case 'compact-long':
        result.notation = 'compact';
        result.compactDisplay = 'long';
        continue;

      case 'scientific':
        result = __assign(__assign(__assign({}, result), {
          notation: 'scientific'
        }), _babel_runtime_corejs3_core_js_instance_reduce__WEBPACK_IMPORTED_MODULE_2___default()(_context = token.options).call(_context, function (all, opt) {
          return __assign(__assign({}, all), parseNotationOptions(opt));
        }, {}));
        continue;

      case 'engineering':
        result = __assign(__assign(__assign({}, result), {
          notation: 'engineering'
        }), _babel_runtime_corejs3_core_js_instance_reduce__WEBPACK_IMPORTED_MODULE_2___default()(_context2 = token.options).call(_context2, function (all, opt) {
          return __assign(__assign({}, all), parseNotationOptions(opt));
        }, {}));
        continue;

      case 'notation-simple':
        result.notation = 'standard';
        continue;
      // https://github.com/unicode-org/icu/blob/master/icu4c/source/i18n/unicode/unumberformatter.h

      case 'unit-width-narrow':
        result.currencyDisplay = 'narrowSymbol';
        result.unitDisplay = 'narrow';
        continue;

      case 'unit-width-short':
        result.currencyDisplay = 'code';
        result.unitDisplay = 'short';
        continue;

      case 'unit-width-full-name':
        result.currencyDisplay = 'name';
        result.unitDisplay = 'long';
        continue;

      case 'unit-width-iso-code':
        result.currencyDisplay = 'symbol';
        continue;
    } // Precision
    // https://github.com/unicode-org/icu/blob/master/docs/userguide/format_parse/numbers/skeletons.md#fraction-precision
    // precision-integer case


    if (FRACTION_PRECISION_REGEX.test(token.stem)) {
      if (token.options.length > 1) {
        throw new RangeError('Fraction-precision stems only accept a single optional option');
      }

      token.stem.replace(FRACTION_PRECISION_REGEX, function (match, g1, g2, g3, g4, g5) {
        // .000* case (before ICU67 it was .000+)
        if (g2 === '*') {
          result.minimumFractionDigits = g1.length;
        } // .### case
        else if (g3 && g3[0] === '#') {
            result.maximumFractionDigits = g3.length;
          } // .00## case
          else if (g4 && g5) {
              result.minimumFractionDigits = g4.length;
              result.maximumFractionDigits = g4.length + g5.length;
            } else {
              result.minimumFractionDigits = g1.length;
              result.maximumFractionDigits = g1.length;
            }

        return '';
      });

      if (token.options.length) {
        result = __assign(__assign({}, result), parseSignificantPrecision(token.options[0]));
      }

      continue;
    }

    if (SIGNIFICANT_PRECISION_REGEX.test(token.stem)) {
      result = __assign(__assign({}, result), parseSignificantPrecision(token.stem));
      continue;
    }

    var signOpts = parseSign(token.stem);

    if (signOpts) {
      result = __assign(__assign({}, result), signOpts);
    }
  }

  return result;
}

/***/ }),

/***/ "S9m2":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.isConcatSpreadable` well-known symbol
// https://tc39.github.io/ecma262/#sec-symbol.isconcatspreadable
defineWellKnownSymbol('isConcatSpreadable');


/***/ }),

/***/ "SYP+":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__("V/Lb");
var formats = __webpack_require__("cYYr");
var has = Object.prototype.hasOwnProperty;

var arrayPrefixGenerators = {
    brackets: function brackets(prefix) {
        return prefix + '[]';
    },
    comma: 'comma',
    indices: function indices(prefix, key) {
        return prefix + '[' + key + ']';
    },
    repeat: function repeat(prefix) {
        return prefix;
    }
};

var isArray = Array.isArray;
var push = Array.prototype.push;
var pushToArray = function (arr, valueOrArray) {
    push.apply(arr, isArray(valueOrArray) ? valueOrArray : [valueOrArray]);
};

var toISO = Date.prototype.toISOString;

var defaultFormat = formats['default'];
var defaults = {
    addQueryPrefix: false,
    allowDots: false,
    charset: 'utf-8',
    charsetSentinel: false,
    delimiter: '&',
    encode: true,
    encoder: utils.encode,
    encodeValuesOnly: false,
    format: defaultFormat,
    formatter: formats.formatters[defaultFormat],
    // deprecated
    indices: false,
    serializeDate: function serializeDate(date) {
        return toISO.call(date);
    },
    skipNulls: false,
    strictNullHandling: false
};

var isNonNullishPrimitive = function isNonNullishPrimitive(v) {
    return typeof v === 'string'
        || typeof v === 'number'
        || typeof v === 'boolean'
        || typeof v === 'symbol'
        || typeof v === 'bigint';
};

var stringify = function stringify(
    object,
    prefix,
    generateArrayPrefix,
    strictNullHandling,
    skipNulls,
    encoder,
    filter,
    sort,
    allowDots,
    serializeDate,
    formatter,
    encodeValuesOnly,
    charset
) {
    var obj = object;
    if (typeof filter === 'function') {
        obj = filter(prefix, obj);
    } else if (obj instanceof Date) {
        obj = serializeDate(obj);
    } else if (generateArrayPrefix === 'comma' && isArray(obj)) {
        obj = obj.join(',');
    }

    if (obj === null) {
        if (strictNullHandling) {
            return encoder && !encodeValuesOnly ? encoder(prefix, defaults.encoder, charset, 'key') : prefix;
        }

        obj = '';
    }

    if (isNonNullishPrimitive(obj) || utils.isBuffer(obj)) {
        if (encoder) {
            var keyValue = encodeValuesOnly ? prefix : encoder(prefix, defaults.encoder, charset, 'key');
            return [formatter(keyValue) + '=' + formatter(encoder(obj, defaults.encoder, charset, 'value'))];
        }
        return [formatter(prefix) + '=' + formatter(String(obj))];
    }

    var values = [];

    if (typeof obj === 'undefined') {
        return values;
    }

    var objKeys;
    if (isArray(filter)) {
        objKeys = filter;
    } else {
        var keys = Object.keys(obj);
        objKeys = sort ? keys.sort(sort) : keys;
    }

    for (var i = 0; i < objKeys.length; ++i) {
        var key = objKeys[i];

        if (skipNulls && obj[key] === null) {
            continue;
        }

        if (isArray(obj)) {
            pushToArray(values, stringify(
                obj[key],
                typeof generateArrayPrefix === 'function' ? generateArrayPrefix(prefix, key) : prefix,
                generateArrayPrefix,
                strictNullHandling,
                skipNulls,
                encoder,
                filter,
                sort,
                allowDots,
                serializeDate,
                formatter,
                encodeValuesOnly,
                charset
            ));
        } else {
            pushToArray(values, stringify(
                obj[key],
                prefix + (allowDots ? '.' + key : '[' + key + ']'),
                generateArrayPrefix,
                strictNullHandling,
                skipNulls,
                encoder,
                filter,
                sort,
                allowDots,
                serializeDate,
                formatter,
                encodeValuesOnly,
                charset
            ));
        }
    }

    return values;
};

var normalizeStringifyOptions = function normalizeStringifyOptions(opts) {
    if (!opts) {
        return defaults;
    }

    if (opts.encoder !== null && opts.encoder !== undefined && typeof opts.encoder !== 'function') {
        throw new TypeError('Encoder has to be a function.');
    }

    var charset = opts.charset || defaults.charset;
    if (typeof opts.charset !== 'undefined' && opts.charset !== 'utf-8' && opts.charset !== 'iso-8859-1') {
        throw new TypeError('The charset option must be either utf-8, iso-8859-1, or undefined');
    }

    var format = formats['default'];
    if (typeof opts.format !== 'undefined') {
        if (!has.call(formats.formatters, opts.format)) {
            throw new TypeError('Unknown format option provided.');
        }
        format = opts.format;
    }
    var formatter = formats.formatters[format];

    var filter = defaults.filter;
    if (typeof opts.filter === 'function' || isArray(opts.filter)) {
        filter = opts.filter;
    }

    return {
        addQueryPrefix: typeof opts.addQueryPrefix === 'boolean' ? opts.addQueryPrefix : defaults.addQueryPrefix,
        allowDots: typeof opts.allowDots === 'undefined' ? defaults.allowDots : !!opts.allowDots,
        charset: charset,
        charsetSentinel: typeof opts.charsetSentinel === 'boolean' ? opts.charsetSentinel : defaults.charsetSentinel,
        delimiter: typeof opts.delimiter === 'undefined' ? defaults.delimiter : opts.delimiter,
        encode: typeof opts.encode === 'boolean' ? opts.encode : defaults.encode,
        encoder: typeof opts.encoder === 'function' ? opts.encoder : defaults.encoder,
        encodeValuesOnly: typeof opts.encodeValuesOnly === 'boolean' ? opts.encodeValuesOnly : defaults.encodeValuesOnly,
        filter: filter,
        formatter: formatter,
        serializeDate: typeof opts.serializeDate === 'function' ? opts.serializeDate : defaults.serializeDate,
        skipNulls: typeof opts.skipNulls === 'boolean' ? opts.skipNulls : defaults.skipNulls,
        sort: typeof opts.sort === 'function' ? opts.sort : null,
        strictNullHandling: typeof opts.strictNullHandling === 'boolean' ? opts.strictNullHandling : defaults.strictNullHandling
    };
};

module.exports = function (object, opts) {
    var obj = object;
    var options = normalizeStringifyOptions(opts);

    var objKeys;
    var filter;

    if (typeof options.filter === 'function') {
        filter = options.filter;
        obj = filter('', obj);
    } else if (isArray(options.filter)) {
        filter = options.filter;
        objKeys = filter;
    }

    var keys = [];

    if (typeof obj !== 'object' || obj === null) {
        return '';
    }

    var arrayFormat;
    if (opts && opts.arrayFormat in arrayPrefixGenerators) {
        arrayFormat = opts.arrayFormat;
    } else if (opts && 'indices' in opts) {
        arrayFormat = opts.indices ? 'indices' : 'repeat';
    } else {
        arrayFormat = 'indices';
    }

    var generateArrayPrefix = arrayPrefixGenerators[arrayFormat];

    if (!objKeys) {
        objKeys = Object.keys(obj);
    }

    if (options.sort) {
        objKeys.sort(options.sort);
    }

    for (var i = 0; i < objKeys.length; ++i) {
        var key = objKeys[i];

        if (options.skipNulls && obj[key] === null) {
            continue;
        }
        pushToArray(keys, stringify(
            obj[key],
            key,
            generateArrayPrefix,
            options.strictNullHandling,
            options.skipNulls,
            options.encode ? options.encoder : null,
            options.filter,
            options.sort,
            options.allowDots,
            options.serializeDate,
            options.formatter,
            options.encodeValuesOnly,
            options.charset
        ));
    }

    var joined = keys.join(options.delimiter);
    var prefix = options.addQueryPrefix === true ? '?' : '';

    if (options.charsetSentinel) {
        if (options.charset === 'iso-8859-1') {
            // encodeURIComponent('&#10003;'), the "numeric entity" representation of a checkmark
            prefix += 'utf8=%26%2310003%3B&';
        } else {
            // encodeURIComponent('✓')
            prefix += 'utf8=%E2%9C%93&';
        }
    }

    return joined.length > 0 ? prefix + joined : '';
};


/***/ }),

/***/ "SYdv":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.toPrimitive` well-known symbol
// https://tc39.github.io/ecma262/#sec-symbol.toprimitive
defineWellKnownSymbol('toPrimitive');


/***/ }),

/***/ "SeRC":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("oNh+");
var inspectSource = __webpack_require__("8msI");

var WeakMap = global.WeakMap;

module.exports = typeof WeakMap === 'function' && /native code/.test(inspectSource(WeakMap));


/***/ }),

/***/ "Sj6f":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("tC4N");

module.exports = parent;


/***/ }),

/***/ "SoW8":
/***/ (function(module, exports) {

module.exports = function anonymous(locals, escapeFn, include, rethrow) {
    rethrow = rethrow || function rethrow(err, str, flnm, lineno, esc) {
        var lines = str.split("\n");
        var start = Math.max(lineno - 3, 0);
        var end = Math.min(lines.length, lineno + 3);
        var filename = esc(flnm);
        var context = lines.slice(start, end).map(function(line, i) {
            var curr = i + start + 1;
            return (curr == lineno ? " >> " : "    ") + curr + "| " + line;
        }).join("\n");
        err.path = filename;
        err.message = (filename || "ejs") + ":" + lineno + "\n" + context + "\n\n" + err.message;
        throw err;
    };
    escapeFn = escapeFn || function(markup) {
        return markup == undefined ? "" : String(markup).replace(_MATCH_HTML, encode_char);
    };
    var _ENCODE_HTML_RULES = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&#34;",
        "'": "&#39;"
    }, _MATCH_HTML = /[&<>'"]/g;
    function encode_char(c) {
        return _ENCODE_HTML_RULES[c] || c;
    }
    var __line = 1, __lines = '<ul class="nav nav-pills"></ul>', __filename = "widgets/activeFilters/bsMain.ejs";
    try {
        var __output = "";
        function __append(s) {
            if (s !== undefined && s !== null) __output += s;
        }
        with (locals || {}) {
            __append('<ul class="nav nav-pills"></ul>');
        }
        return __output;
    } catch (e) {
        rethrow(e, __lines, __filename, __line, escapeFn);
    }
}

/***/ }),

/***/ "SqXu":
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__("n9AK");
var parseIntImplementation = __webpack_require__("z2yT");

// `parseInt` method
// https://tc39.github.io/ecma262/#sec-parseint-string-radix
$({ global: true, forced: parseInt != parseIntImplementation }, {
  parseInt: parseIntImplementation
});


/***/ }),

/***/ "TN3B":
/***/ (function(module, exports, __webpack_require__) {

var IS_PURE = __webpack_require__("DpO5");
var store = __webpack_require__("xgf2");

(module.exports = function (key, value) {
  return store[key] || (store[key] = value !== undefined ? value : {});
})('versions', []).push({
  version: '3.6.5',
  mode: IS_PURE ? 'pure' : 'global',
  copyright: '© 2020 Denis Pushkarev (zloirock.ru)'
});


/***/ }),

/***/ "TbR9":
/***/ (function(module, exports, __webpack_require__) {

var NATIVE_SYMBOL = __webpack_require__("56Cj");

module.exports = NATIVE_SYMBOL
  // eslint-disable-next-line no-undef
  && !Symbol.sham
  // eslint-disable-next-line no-undef
  && typeof Symbol.iterator == 'symbol';


/***/ }),

/***/ "TkGI":
/***/ (function(module, exports, __webpack_require__) {

var wellKnownSymbol = __webpack_require__("fVMg");

exports.f = wellKnownSymbol;


/***/ }),

/***/ "Tme5":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.hasInstance` well-known symbol
// https://tc39.github.io/ecma262/#sec-symbol.hasinstance
defineWellKnownSymbol('hasInstance');


/***/ }),

/***/ "Tycz":
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__("n9AK");
var isArray = __webpack_require__("ygwS");

// `Array.isArray` method
// https://tc39.github.io/ecma262/#sec-array.isarray
$({ target: 'Array', stat: true }, {
  isArray: isArray
});


/***/ }),

/***/ "Uh/D":
/***/ (function(module, exports) {

module.exports = function () { /* empty */ };


/***/ }),

/***/ "UmhL":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var TO_STRING_TAG_SUPPORT = __webpack_require__("POz8");
var classof = __webpack_require__("2gZs");

// `Object.prototype.toString` method implementation
// https://tc39.github.io/ecma262/#sec-object.prototype.tostring
module.exports = TO_STRING_TAG_SUPPORT ? {}.toString : function toString() {
  return '[object ' + classof(this) + ']';
};


/***/ }),

/***/ "UwuC":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("HWa3");

/***/ }),

/***/ "V/Lb":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var has = Object.prototype.hasOwnProperty;
var isArray = Array.isArray;

var hexTable = (function () {
    var array = [];
    for (var i = 0; i < 256; ++i) {
        array.push('%' + ((i < 16 ? '0' : '') + i.toString(16)).toUpperCase());
    }

    return array;
}());

var compactQueue = function compactQueue(queue) {
    while (queue.length > 1) {
        var item = queue.pop();
        var obj = item.obj[item.prop];

        if (isArray(obj)) {
            var compacted = [];

            for (var j = 0; j < obj.length; ++j) {
                if (typeof obj[j] !== 'undefined') {
                    compacted.push(obj[j]);
                }
            }

            item.obj[item.prop] = compacted;
        }
    }
};

var arrayToObject = function arrayToObject(source, options) {
    var obj = options && options.plainObjects ? Object.create(null) : {};
    for (var i = 0; i < source.length; ++i) {
        if (typeof source[i] !== 'undefined') {
            obj[i] = source[i];
        }
    }

    return obj;
};

var merge = function merge(target, source, options) {
    /* eslint no-param-reassign: 0 */
    if (!source) {
        return target;
    }

    if (typeof source !== 'object') {
        if (isArray(target)) {
            target.push(source);
        } else if (target && typeof target === 'object') {
            if ((options && (options.plainObjects || options.allowPrototypes)) || !has.call(Object.prototype, source)) {
                target[source] = true;
            }
        } else {
            return [target, source];
        }

        return target;
    }

    if (!target || typeof target !== 'object') {
        return [target].concat(source);
    }

    var mergeTarget = target;
    if (isArray(target) && !isArray(source)) {
        mergeTarget = arrayToObject(target, options);
    }

    if (isArray(target) && isArray(source)) {
        source.forEach(function (item, i) {
            if (has.call(target, i)) {
                var targetItem = target[i];
                if (targetItem && typeof targetItem === 'object' && item && typeof item === 'object') {
                    target[i] = merge(targetItem, item, options);
                } else {
                    target.push(item);
                }
            } else {
                target[i] = item;
            }
        });
        return target;
    }

    return Object.keys(source).reduce(function (acc, key) {
        var value = source[key];

        if (has.call(acc, key)) {
            acc[key] = merge(acc[key], value, options);
        } else {
            acc[key] = value;
        }
        return acc;
    }, mergeTarget);
};

var assign = function assignSingleSource(target, source) {
    return Object.keys(source).reduce(function (acc, key) {
        acc[key] = source[key];
        return acc;
    }, target);
};

var decode = function (str, decoder, charset) {
    var strWithoutPlus = str.replace(/\+/g, ' ');
    if (charset === 'iso-8859-1') {
        // unescape never throws, no try...catch needed:
        return strWithoutPlus.replace(/%[0-9a-f]{2}/gi, unescape);
    }
    // utf-8
    try {
        return decodeURIComponent(strWithoutPlus);
    } catch (e) {
        return strWithoutPlus;
    }
};

var encode = function encode(str, defaultEncoder, charset) {
    // This code was originally written by Brian White (mscdex) for the io.js core querystring library.
    // It has been adapted here for stricter adherence to RFC 3986
    if (str.length === 0) {
        return str;
    }

    var string = str;
    if (typeof str === 'symbol') {
        string = Symbol.prototype.toString.call(str);
    } else if (typeof str !== 'string') {
        string = String(str);
    }

    if (charset === 'iso-8859-1') {
        return escape(string).replace(/%u[0-9a-f]{4}/gi, function ($0) {
            return '%26%23' + parseInt($0.slice(2), 16) + '%3B';
        });
    }

    var out = '';
    for (var i = 0; i < string.length; ++i) {
        var c = string.charCodeAt(i);

        if (
            c === 0x2D // -
            || c === 0x2E // .
            || c === 0x5F // _
            || c === 0x7E // ~
            || (c >= 0x30 && c <= 0x39) // 0-9
            || (c >= 0x41 && c <= 0x5A) // a-z
            || (c >= 0x61 && c <= 0x7A) // A-Z
        ) {
            out += string.charAt(i);
            continue;
        }

        if (c < 0x80) {
            out = out + hexTable[c];
            continue;
        }

        if (c < 0x800) {
            out = out + (hexTable[0xC0 | (c >> 6)] + hexTable[0x80 | (c & 0x3F)]);
            continue;
        }

        if (c < 0xD800 || c >= 0xE000) {
            out = out + (hexTable[0xE0 | (c >> 12)] + hexTable[0x80 | ((c >> 6) & 0x3F)] + hexTable[0x80 | (c & 0x3F)]);
            continue;
        }

        i += 1;
        c = 0x10000 + (((c & 0x3FF) << 10) | (string.charCodeAt(i) & 0x3FF));
        out += hexTable[0xF0 | (c >> 18)]
            + hexTable[0x80 | ((c >> 12) & 0x3F)]
            + hexTable[0x80 | ((c >> 6) & 0x3F)]
            + hexTable[0x80 | (c & 0x3F)];
    }

    return out;
};

var compact = function compact(value) {
    var queue = [{ obj: { o: value }, prop: 'o' }];
    var refs = [];

    for (var i = 0; i < queue.length; ++i) {
        var item = queue[i];
        var obj = item.obj[item.prop];

        var keys = Object.keys(obj);
        for (var j = 0; j < keys.length; ++j) {
            var key = keys[j];
            var val = obj[key];
            if (typeof val === 'object' && val !== null && refs.indexOf(val) === -1) {
                queue.push({ obj: obj, prop: key });
                refs.push(val);
            }
        }
    }

    compactQueue(queue);

    return value;
};

var isRegExp = function isRegExp(obj) {
    return Object.prototype.toString.call(obj) === '[object RegExp]';
};

var isBuffer = function isBuffer(obj) {
    if (!obj || typeof obj !== 'object') {
        return false;
    }

    return !!(obj.constructor && obj.constructor.isBuffer && obj.constructor.isBuffer(obj));
};

var combine = function combine(a, b) {
    return [].concat(a, b);
};

module.exports = {
    arrayToObject: arrayToObject,
    assign: assign,
    combine: combine,
    compact: compact,
    decode: decode,
    encode: encode,
    isBuffer: isBuffer,
    isRegExp: isRegExp,
    merge: merge
};


/***/ }),

/***/ "VCi3":
/***/ (function(module, exports, __webpack_require__) {

var path = __webpack_require__("PjZX");
var global = __webpack_require__("9JhN");

var aFunction = function (variable) {
  return typeof variable == 'function' ? variable : undefined;
};

module.exports = function (namespace, method) {
  return arguments.length < 2 ? aFunction(path[namespace]) || aFunction(global[namespace])
    : path[namespace] && path[namespace][method] || global[namespace] && global[namespace][method];
};


/***/ }),

/***/ "VPR5":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("oNh+");
var setToStringTag = __webpack_require__("CtlU");

// JSON[@@toStringTag] property
// https://tc39.github.io/ecma262/#sec-json-@@tostringtag
setToStringTag(global.JSON, 'JSON', true);


/***/ }),

/***/ "VQ32":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("cY0r");

module.exports = parent;


/***/ }),

/***/ "VcbD":
/***/ (function(module, exports, __webpack_require__) {

// toObject with fallback for non-array-like ES3 strings
var IndexedObject = __webpack_require__("fDXD");
var requireObjectCoercible = __webpack_require__("j0cD");

module.exports = function (it) {
  return IndexedObject(requireObjectCoercible(it));
};


/***/ }),

/***/ "Vl7J":
/***/ (function(module, exports) {

module.exports = true;


/***/ }),

/***/ "VluA":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("uuWK");

/***/ }),

/***/ "WNMA":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var fixRegExpWellKnownSymbolLogic = __webpack_require__("lbJE");
var anObject = __webpack_require__("FXyv");
var toLength = __webpack_require__("tJVe");
var requireObjectCoercible = __webpack_require__("cww3");
var advanceStringIndex = __webpack_require__("4/YM");
var regExpExec = __webpack_require__("34wW");

// @@match logic
fixRegExpWellKnownSymbolLogic('match', 1, function (MATCH, nativeMatch, maybeCallNative) {
  return [
    // `String.prototype.match` method
    // https://tc39.github.io/ecma262/#sec-string.prototype.match
    function match(regexp) {
      var O = requireObjectCoercible(this);
      var matcher = regexp == undefined ? undefined : regexp[MATCH];
      return matcher !== undefined ? matcher.call(regexp, O) : new RegExp(regexp)[MATCH](String(O));
    },
    // `RegExp.prototype[@@match]` method
    // https://tc39.github.io/ecma262/#sec-regexp.prototype-@@match
    function (regexp) {
      var res = maybeCallNative(nativeMatch, regexp, this);
      if (res.done) return res.value;

      var rx = anObject(regexp);
      var S = String(this);

      if (!rx.global) return regExpExec(rx, S);

      var fullUnicode = rx.unicode;
      rx.lastIndex = 0;
      var A = [];
      var n = 0;
      var result;
      while ((result = regExpExec(rx, S)) !== null) {
        var matchStr = String(result[0]);
        A[n] = matchStr;
        if (matchStr === '') rx.lastIndex = advanceStringIndex(S, toLength(rx.lastIndex), fullUnicode);
        n++;
      }
      return n === 0 ? null : A;
    }
  ];
});


/***/ }),

/***/ "WRdu":
/***/ (function(module, exports, __webpack_require__) {

var NATIVE_WEAK_MAP = __webpack_require__("SeRC");
var global = __webpack_require__("oNh+");
var isObject = __webpack_require__("H3h0");
var createNonEnumerableProperty = __webpack_require__("jNzf");
var objectHas = __webpack_require__("zNvU");
var sharedKey = __webpack_require__("iDMO");
var hiddenKeys = __webpack_require__("lyTg");

var WeakMap = global.WeakMap;
var set, get, has;

var enforce = function (it) {
  return has(it) ? get(it) : set(it, {});
};

var getterFor = function (TYPE) {
  return function (it) {
    var state;
    if (!isObject(it) || (state = get(it)).type !== TYPE) {
      throw TypeError('Incompatible receiver, ' + TYPE + ' required');
    } return state;
  };
};

if (NATIVE_WEAK_MAP) {
  var store = new WeakMap();
  var wmget = store.get;
  var wmhas = store.has;
  var wmset = store.set;
  set = function (it, metadata) {
    wmset.call(store, it, metadata);
    return metadata;
  };
  get = function (it) {
    return wmget.call(store, it) || {};
  };
  has = function (it) {
    return wmhas.call(store, it);
  };
} else {
  var STATE = sharedKey('state');
  hiddenKeys[STATE] = true;
  set = function (it, metadata) {
    createNonEnumerableProperty(it, STATE, metadata);
    return metadata;
  };
  get = function (it) {
    return objectHas(it, STATE) ? it[STATE] : {};
  };
  has = function (it) {
    return objectHas(it, STATE);
  };
}

module.exports = {
  set: set,
  get: get,
  has: has,
  enforce: enforce,
  getterFor: getterFor
};


/***/ }),

/***/ "WTd3":
/***/ (function(module, exports) {

var toString = {}.toString;

module.exports = function (it) {
  return toString.call(it).slice(8, -1);
};


/***/ }),

/***/ "WVwf":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("kD1X");

/***/ }),

/***/ "WbkG":
/***/ (function(module, exports, __webpack_require__) {

var wellKnownSymbol = __webpack_require__("HVcX");

var TO_STRING_TAG = wellKnownSymbol('toStringTag');
var test = {};

test[TO_STRING_TAG] = 'z';

module.exports = String(test) === '[object z]';


/***/ }),

/***/ "WxKw":
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__("1Mu/");
var definePropertyModule = __webpack_require__("q9+l");
var createPropertyDescriptor = __webpack_require__("lhjL");

module.exports = DESCRIPTORS ? function (object, key, value) {
  return definePropertyModule.f(object, key, createPropertyDescriptor(1, value));
} : function (object, key, value) {
  object[key] = value;
  return object;
};


/***/ }),

/***/ "X7cO":
/***/ (function(module, exports) {

// empty


/***/ }),

/***/ "X85A":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("K50e");

module.exports = parent;


/***/ }),

/***/ "XR+Y":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.asyncIterator` well-known symbol
// https://tc39.github.io/ecma262/#sec-symbol.asynciterator
defineWellKnownSymbol('asyncIterator');


/***/ }),

/***/ "XSsT":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("lg3o");

/***/ }),

/***/ "XU0c":
/***/ (function(module, exports) {

module.exports = function (exec) {
  try {
    return !!exec();
  } catch (error) {
    return true;
  }
};


/***/ }),

/***/ "XkVi":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__("7xRU");

var _keysInstanceProperty = __webpack_require__("FVjd");

var _parseInt = __webpack_require__("I2Za");

var _forEachInstanceProperty = __webpack_require__("i6Tr");

var _indexOfInstanceProperty = __webpack_require__("0wSO");

var _Object$assign = __webpack_require__("eDnP");

var _context;

var getLabel = __webpack_require__("vMH7")(_Object$assign(__webpack_require__("m/b9"), __webpack_require__("/q4V")));

var months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
exports.setOnReady = setOnReady;

var UID = 0,
    LANG = 1,
    MODE = 2,
    cn = __webpack_require__("ycY6"),
    wLib = __webpack_require__("NXqE"),
    debug = __webpack_require__("NOtv"),
    domLib = __webpack_require__("+tnu"),
    onReady;

if (_indexOfInstanceProperty(_context = ['tpl', 'development']).call(_context, window.env) !== -1) {
  debug.enable('*');
}

var widget = function widget(elem, options) {
  var log,
      enabled = false,
      activeFilters = {},
      dom = domLib(elem),
      lang = 'fr',
      categories = {},
      tags = {},
      organizations = {},
      controller;
  return function () {
    lang = options.anchorConfig[LANG];
    var uid = options.anchorConfig[UID],
        log = debug('activeFilters widget ' + uid + ', lang ' + lang);

    if (options.anchorConfig[MODE]) {
      dom.setMode(options.anchorConfig[MODE]);
    }

    dom.setOnRemove(_onFilterRemove);
    log('initing');
    controller = options.register(wLib.interface('activeFilters', uid, {
      enable: enable,
      disable: disable
    }));
    controller.getControlData(function (data) {
      _indexLabels(data);

      log('init complete, enable to render');
      if (onReady) onReady();
    });
  }();

  function disable() {
    enabled = false;

    _render();
  }

  function enable(reqParams) {
    var newFilters = [],
        reqTags,
        tagLabels;
    enabled = true;

    if (reqParams.neLat) {
      newFilters.push({
        type: 'geo',
        label: getLabel('map', lang),
        keys: ['neLat', 'neLng', 'swLat', 'swLng']
      });
    }

    if (reqParams.from) {
      if (reqParams.to && reqParams.to !== reqParams.from) {
        newFilters.push({
          type: 'time',
          label: renderLabel(reqParams.from, reqParams.to),
          keys: ['from', 'to']
        });
      } else {
        newFilters.push({
          type: 'time',
          label: renderLabel(reqParams.from),
          keys: ['from', 'to']
        });
      }
    }

    if (reqParams.what) {
      newFilters.push({
        type: 'search',
        label: reqParams.what,
        keys: ['what']
      });
    }

    if (reqParams.category) {
      newFilters.push({
        type: 'category',
        label: categories[reqParams.category],
        keys: ['category']
      });
    }

    if (reqParams.tags) {
      reqTags = typeof reqParams.tags == 'string' ? [reqParams.tags] : reqParams.tags;
      tagLabels = [];

      _forEachInstanceProperty(cn).call(cn, reqTags, function (tag) {
        tagLabels.push(tags[tag]);
      });

      newFilters.push({
        type: 'tags',
        label: tagLabels.join(', '),
        keys: ['tags']
      });
    }

    if (reqParams.location) {
      newFilters.push({
        type: 'geo',
        label: getLabel('location', lang),
        keys: ['location']
      });
    }

    if (reqParams.org) {
      newFilters.push({
        type: 'contributor',
        label: organizations[reqParams.org],
        keys: ['org']
      });
    }

    if (!!_parseInt(reqParams.passed)) {
      newFilters.push({
        type: 'time',
        label: getLabel('passed', lang),
        keys: ['passed']
      });
    }

    activeFilters = newFilters;

    _render();
  }

  function _render() {
    dom.render({
      filters: activeFilters,
      enabled: enabled
    });
  }

  function _indexLabels(data) {
    _forEachInstanceProperty(cn).call(cn, data.ct, function (c) {
      categories[c.s] = c.c;
    });

    _forEachInstanceProperty(cn).call(cn, data.t, function (t) {
      tags[t.s] = t.t;
    });

    if (data.org) {
      _forEachInstanceProperty(cn).call(cn, data.org, function (o) {
        organizations[o.s] = o.l;
      });
    }
  }

  function _onFilterRemove(filter) {
    var keysToRemove = {};

    if (!enabled) {
      log('remove filter ignored, widget not enabled');
      return;
    }

    _forEachInstanceProperty(cn).call(cn, _keysInstanceProperty(filter), function (key) {
      keysToRemove[key] = null;
    });

    controller.update('activeFilters', keysToRemove);
  }

  function renderLabel(start, end) {
    if (end) {
      return getLabel('fromTo', {
        start: start,
        end: end
      }, lang);
    } else {
      return renderDate(start);
    }
  }

  function renderDate(d) {
    var date = new Date(d),
        now = new Date(),
        displayYear = date.getFullYear() !== now.getFullYear();
    return date.getDate() + ' ' + getLabel(months[date.getMonth()], lang) + (displayYear ? ' ' + date.getFullYear() : '');
  }
};

function setOnReady(cb) {
  onReady = cb;
}

__webpack_require__("KT41")(function (register) {
  wLib.forEachAnchor('.cbpgft', {
    register: register
  }, widget);
});

/***/ }),

/***/ "YH+Y":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("K1lx");
var path = __webpack_require__("j0PW");

module.exports = path.Object.setPrototypeOf;


/***/ }),

/***/ "YPef":
/***/ (function(module, exports, __webpack_require__) {

var splice = __webpack_require__("nVA8");

var ArrayPrototype = Array.prototype;

module.exports = function (it) {
  var own = it.splice;
  return it === ArrayPrototype || (it instanceof Array && own === ArrayPrototype.splice) ? splice : own;
};


/***/ }),

/***/ "Ya2h":
/***/ (function(module, exports, __webpack_require__) {

var requireObjectCoercible = __webpack_require__("cww3");
var whitespaces = __webpack_require__("+/eK");

var whitespace = '[' + whitespaces + ']';
var ltrim = RegExp('^' + whitespace + whitespace + '*');
var rtrim = RegExp(whitespace + whitespace + '*$');

// `String.prototype.{ trim, trimStart, trimEnd, trimLeft, trimRight }` methods implementation
var createMethod = function (TYPE) {
  return function ($this) {
    var string = String(requireObjectCoercible($this));
    if (TYPE & 1) string = string.replace(ltrim, '');
    if (TYPE & 2) string = string.replace(rtrim, '');
    return string;
  };
};

module.exports = {
  // `String.prototype.{ trimLeft, trimStart }` methods
  // https://tc39.github.io/ecma262/#sec-string.prototype.trimstart
  start: createMethod(1),
  // `String.prototype.{ trimRight, trimEnd }` methods
  // https://tc39.github.io/ecma262/#sec-string.prototype.trimend
  end: createMethod(2),
  // `String.prototype.trim` method
  // https://tc39.github.io/ecma262/#sec-string.prototype.trim
  trim: createMethod(3)
};


/***/ }),

/***/ "YkBG":
/***/ (function(module, exports, __webpack_require__) {

var indexOf = __webpack_require__("lOCh");

var ArrayPrototype = Array.prototype;

module.exports = function (it) {
  var own = it.indexOf;
  return it === ArrayPrototype || (it instanceof Array && own === ArrayPrototype.indexOf) ? indexOf : own;
};


/***/ }),

/***/ "Ysgh":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var fixRegExpWellKnownSymbolLogic = __webpack_require__("lbJE");
var isRegExp = __webpack_require__("jl0/");
var anObject = __webpack_require__("FXyv");
var requireObjectCoercible = __webpack_require__("cww3");
var speciesConstructor = __webpack_require__("Qzre");
var advanceStringIndex = __webpack_require__("4/YM");
var toLength = __webpack_require__("tJVe");
var callRegExpExec = __webpack_require__("34wW");
var regexpExec = __webpack_require__("QsUS");
var fails = __webpack_require__("ct80");

var arrayPush = [].push;
var min = Math.min;
var MAX_UINT32 = 0xFFFFFFFF;

// babel-minify transpiles RegExp('x', 'y') -> /x/y and it causes SyntaxError
var SUPPORTS_Y = !fails(function () { return !RegExp(MAX_UINT32, 'y'); });

// @@split logic
fixRegExpWellKnownSymbolLogic('split', 2, function (SPLIT, nativeSplit, maybeCallNative) {
  var internalSplit;
  if (
    'abbc'.split(/(b)*/)[1] == 'c' ||
    'test'.split(/(?:)/, -1).length != 4 ||
    'ab'.split(/(?:ab)*/).length != 2 ||
    '.'.split(/(.?)(.?)/).length != 4 ||
    '.'.split(/()()/).length > 1 ||
    ''.split(/.?/).length
  ) {
    // based on es5-shim implementation, need to rework it
    internalSplit = function (separator, limit) {
      var string = String(requireObjectCoercible(this));
      var lim = limit === undefined ? MAX_UINT32 : limit >>> 0;
      if (lim === 0) return [];
      if (separator === undefined) return [string];
      // If `separator` is not a regex, use native split
      if (!isRegExp(separator)) {
        return nativeSplit.call(string, separator, lim);
      }
      var output = [];
      var flags = (separator.ignoreCase ? 'i' : '') +
                  (separator.multiline ? 'm' : '') +
                  (separator.unicode ? 'u' : '') +
                  (separator.sticky ? 'y' : '');
      var lastLastIndex = 0;
      // Make `global` and avoid `lastIndex` issues by working with a copy
      var separatorCopy = new RegExp(separator.source, flags + 'g');
      var match, lastIndex, lastLength;
      while (match = regexpExec.call(separatorCopy, string)) {
        lastIndex = separatorCopy.lastIndex;
        if (lastIndex > lastLastIndex) {
          output.push(string.slice(lastLastIndex, match.index));
          if (match.length > 1 && match.index < string.length) arrayPush.apply(output, match.slice(1));
          lastLength = match[0].length;
          lastLastIndex = lastIndex;
          if (output.length >= lim) break;
        }
        if (separatorCopy.lastIndex === match.index) separatorCopy.lastIndex++; // Avoid an infinite loop
      }
      if (lastLastIndex === string.length) {
        if (lastLength || !separatorCopy.test('')) output.push('');
      } else output.push(string.slice(lastLastIndex));
      return output.length > lim ? output.slice(0, lim) : output;
    };
  // Chakra, V8
  } else if ('0'.split(undefined, 0).length) {
    internalSplit = function (separator, limit) {
      return separator === undefined && limit === 0 ? [] : nativeSplit.call(this, separator, limit);
    };
  } else internalSplit = nativeSplit;

  return [
    // `String.prototype.split` method
    // https://tc39.github.io/ecma262/#sec-string.prototype.split
    function split(separator, limit) {
      var O = requireObjectCoercible(this);
      var splitter = separator == undefined ? undefined : separator[SPLIT];
      return splitter !== undefined
        ? splitter.call(separator, O, limit)
        : internalSplit.call(String(O), separator, limit);
    },
    // `RegExp.prototype[@@split]` method
    // https://tc39.github.io/ecma262/#sec-regexp.prototype-@@split
    //
    // NOTE: This cannot be properly polyfilled in engines that don't support
    // the 'y' flag.
    function (regexp, limit) {
      var res = maybeCallNative(internalSplit, regexp, this, limit, internalSplit !== nativeSplit);
      if (res.done) return res.value;

      var rx = anObject(regexp);
      var S = String(this);
      var C = speciesConstructor(rx, RegExp);

      var unicodeMatching = rx.unicode;
      var flags = (rx.ignoreCase ? 'i' : '') +
                  (rx.multiline ? 'm' : '') +
                  (rx.unicode ? 'u' : '') +
                  (SUPPORTS_Y ? 'y' : 'g');

      // ^(? + rx + ) is needed, in combination with some S slicing, to
      // simulate the 'y' flag.
      var splitter = new C(SUPPORTS_Y ? rx : '^(?:' + rx.source + ')', flags);
      var lim = limit === undefined ? MAX_UINT32 : limit >>> 0;
      if (lim === 0) return [];
      if (S.length === 0) return callRegExpExec(splitter, S) === null ? [S] : [];
      var p = 0;
      var q = 0;
      var A = [];
      while (q < S.length) {
        splitter.lastIndex = SUPPORTS_Y ? q : 0;
        var z = callRegExpExec(splitter, SUPPORTS_Y ? S : S.slice(q));
        var e;
        if (
          z === null ||
          (e = min(toLength(splitter.lastIndex + (SUPPORTS_Y ? 0 : q)), S.length)) === p
        ) {
          q = advanceStringIndex(S, q, unicodeMatching);
        } else {
          A.push(S.slice(p, q));
          if (A.length === lim) return A;
          for (var i = 1; i <= z.length - 1; i++) {
            A.push(z[i]);
            if (A.length === lim) return A;
          }
          q = p = e;
        }
      }
      A.push(S.slice(p));
      return A;
    }
  ];
}, !SUPPORTS_Y);


/***/ }),

/***/ "ZMhG":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("/HG3");

module.exports = parent;


/***/ }),

/***/ "ZdBB":
/***/ (function(module, exports, __webpack_require__) {

var internalObjectKeys = __webpack_require__("yRya");
var enumBugKeys = __webpack_require__("sX5C");

var hiddenKeys = enumBugKeys.concat('length', 'prototype');

// `Object.getOwnPropertyNames` method
// https://tc39.github.io/ecma262/#sec-object.getownpropertynames
exports.f = Object.getOwnPropertyNames || function getOwnPropertyNames(O) {
  return internalObjectKeys(O, hiddenKeys);
};


/***/ }),

/***/ "a+Rm":
/***/ (function(module, exports) {

/**
 * Helpers.
 */

var s = 1000;
var m = s * 60;
var h = m * 60;
var d = h * 24;
var w = d * 7;
var y = d * 365.25;

/**
 * Parse or format the given `val`.
 *
 * Options:
 *
 *  - `long` verbose formatting [false]
 *
 * @param {String|Number} val
 * @param {Object} [options]
 * @throws {Error} throw an error if val is not a non-empty string or a number
 * @return {String|Number}
 * @api public
 */

module.exports = function(val, options) {
  options = options || {};
  var type = typeof val;
  if (type === 'string' && val.length > 0) {
    return parse(val);
  } else if (type === 'number' && isFinite(val)) {
    return options.long ? fmtLong(val) : fmtShort(val);
  }
  throw new Error(
    'val is not a non-empty string or a valid number. val=' +
      JSON.stringify(val)
  );
};

/**
 * Parse the given `str` and return milliseconds.
 *
 * @param {String} str
 * @return {Number}
 * @api private
 */

function parse(str) {
  str = String(str);
  if (str.length > 100) {
    return;
  }
  var match = /^(-?(?:\d+)?\.?\d+) *(milliseconds?|msecs?|ms|seconds?|secs?|s|minutes?|mins?|m|hours?|hrs?|h|days?|d|weeks?|w|years?|yrs?|y)?$/i.exec(
    str
  );
  if (!match) {
    return;
  }
  var n = parseFloat(match[1]);
  var type = (match[2] || 'ms').toLowerCase();
  switch (type) {
    case 'years':
    case 'year':
    case 'yrs':
    case 'yr':
    case 'y':
      return n * y;
    case 'weeks':
    case 'week':
    case 'w':
      return n * w;
    case 'days':
    case 'day':
    case 'd':
      return n * d;
    case 'hours':
    case 'hour':
    case 'hrs':
    case 'hr':
    case 'h':
      return n * h;
    case 'minutes':
    case 'minute':
    case 'mins':
    case 'min':
    case 'm':
      return n * m;
    case 'seconds':
    case 'second':
    case 'secs':
    case 'sec':
    case 's':
      return n * s;
    case 'milliseconds':
    case 'millisecond':
    case 'msecs':
    case 'msec':
    case 'ms':
      return n;
    default:
      return undefined;
  }
}

/**
 * Short format for `ms`.
 *
 * @param {Number} ms
 * @return {String}
 * @api private
 */

function fmtShort(ms) {
  var msAbs = Math.abs(ms);
  if (msAbs >= d) {
    return Math.round(ms / d) + 'd';
  }
  if (msAbs >= h) {
    return Math.round(ms / h) + 'h';
  }
  if (msAbs >= m) {
    return Math.round(ms / m) + 'm';
  }
  if (msAbs >= s) {
    return Math.round(ms / s) + 's';
  }
  return ms + 'ms';
}

/**
 * Long format for `ms`.
 *
 * @param {Number} ms
 * @return {String}
 * @api private
 */

function fmtLong(ms) {
  var msAbs = Math.abs(ms);
  if (msAbs >= d) {
    return plural(ms, msAbs, d, 'day');
  }
  if (msAbs >= h) {
    return plural(ms, msAbs, h, 'hour');
  }
  if (msAbs >= m) {
    return plural(ms, msAbs, m, 'minute');
  }
  if (msAbs >= s) {
    return plural(ms, msAbs, s, 'second');
  }
  return ms + ' ms';
}

/**
 * Pluralization helper.
 */

function plural(ms, msAbs, n, name) {
  var isPlural = msAbs >= n * 1.5;
  return Math.round(ms / n) + ' ' + name + (isPlural ? 's' : '');
}


/***/ }),

/***/ "aDtO":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__("iKE+");

__webpack_require__("KqXw");

__webpack_require__("DZ+c");

__webpack_require__("MvUL");

__webpack_require__("Ysgh");

var _setTimeout = __webpack_require__("yC+K");

var _indexOfInstanceProperty = __webpack_require__("0wSO");

var _typeof = __webpack_require__("p853");

var qs = __webpack_require__("pu3o"),
    utils = __webpack_require__("QkVY");

module.exports = {
  el: el,
  els: els,
  addEvent: addEvent,
  // add an event to an element 
  removeEvent: removeEvent,
  whenReady: whenReady,
  // executes callback when dom is ready or if dom is ready
  asapReady: asapReady,
  // executes cb as soon as elem targetted by elem ( or body by default ) exists.
  loadInLocation: loadInLocation,
  hasClass: hasClass,
  addClass: addClass,
  removeClass: removeClass,
  forEach: forEach,
  childObject: childObject,
  preventDefault: preventDefault,
  isElement: isElement,
  nl2br: nl2br
};

function isElement(o) {
  return (typeof HTMLElement === "undefined" ? "undefined" : _typeof(HTMLElement)) === "object" ? o instanceof HTMLElement : //DOM2
  o && _typeof(o) === "object" && o !== null && o.nodeType === 1 && typeof o.nodeName === "string";
}

function preventDefault(event) {
  event.preventDefault ? event.preventDefault() : event.returnValue = false;
}

;

function childObject(elem, index) {
  var i = 0,
      realI = 0;

  while (elem.childNodes[i]) {
    if (elem.childNodes[i].nodeType == 1) {
      if (realI == index) return elem.childNodes[i];
      realI++;
    }

    i++;
  }

  return false;
}

function hasClass(element, cls) {
  var _context;

  return _indexOfInstanceProperty(_context = ' ' + element.className + ' ').call(_context, ' ' + cls + ' ') > -1;
}

function addClass(element, className) {
  if (!hasClass(element, className)) element.className = element.className + ' ' + className;
}

function removeClass(element, cls) {
  if (hasClass(element, cls)) {
    var regex = new RegExp(cls, 'g');
    element.className = element.className.replace(regex, '');
  }
}

function els(node, selector) {
  var _context2;

  if (typeof node == 'string') {
    selector = node;
    node = document;
  }

  var prefix = selector.substr(0, 1);

  if (_indexOfInstanceProperty(_context2 = '.#,').call(_context2, prefix) !== -1) {
    selector = selector.substr(1);
  }

  if (prefix == '.') {
    return getElementsByClassName(node, selector);
  } else if (prefix == '#') {
    var result = node.getElementById(selector);

    if (result) {
      return [result];
    } else {
      return [];
    }
  } else {
    return node.getElementsByTagName(selector);
  }
}

;

function el(node, selector) {
  var results = els(node, selector);
  return results.length ? results[0] : null;
}

function whenReady(cb) {
  if (document.readyState === 'complete') {
    cb();
  } else {
    addEvent(window, 'load', cb);
  }
}

function asapReady(selector, timeout, cb) {
  if (arguments.length == 1) {
    cb = selector;
    timeout = 0;
    selector = 'body';
  } else if (arguments.length == 2) {
    cb = timeout;
    timeout = 0;
  }

  if (el(selector)) return cb();

  _setTimeout(function () {
    asapReady(selector, Math.min((timeout + 10) * 2, 10000), cb);
  }, timeout);
}

function loadInLocation(values) {
  var href = window.location.href.split('?')[0];

  if (utils.size(values)) {
    href += '?' + qs.stringify(values);
  }

  return href;
}
/**
 * cross browser add event
 */


function addEvent(elem, types, eventHandle) {
  if (elem == null || elem == undefined) return;
  if (typeof types == 'string') types = [types];
  forEach(types, function (type) {
    if (elem.addEventListener) {
      elem.addEventListener(type, eventHandle, false);
    } else if (elem.attachEvent) {
      elem.attachEvent('on' + type, eventHandle);
    } else {
      elem['on' + type] = eventHandle;
    }
  });
}

function removeEvent(elem, types, eventHandle) {
  if (elem === null || elem === undefined) return;
  if (typeof types == 'string') types = [types];
  forEach(types, function (type) {
    if (elem.removeEventListener) {
      elem.removeEventListener(type, eventHandle, false);
    } else if (elem.detachEvent) {
      elem.detachEvent('on' + type, eventHandle);
    } else {
      elem["on" + type] = null;
    }
  });
}

;

function forEach(array, action) {
  for (var i = 0; i < array.length; i++) {
    action(array[i]);
  }
}

function getElementsByClassName(node, className) {
  if (typeof node == 'string') {
    className = node;
    node = document;
  }

  var a = [],
      re = new RegExp('(^| )' + className + '( |$)'),
      els = node.getElementsByTagName('*');

  for (var i = 0, j = els.length; i < j; i++) {
    if (re.test(els[i].className)) {
      a.push(els[i]);
    }
  }

  return a;
}

function nl2br(str, is_xhtml) {
  var breakTag = is_xhtml || typeof is_xhtml === 'undefined' ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display

  return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

/***/ }),

/***/ "amH4":
/***/ (function(module, exports) {

var toString = {}.toString;

module.exports = function (it) {
  return toString.call(it).slice(8, -1);
};


/***/ }),

/***/ "aoZ+":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("dSaG");
var isArray = __webpack_require__("xt6W");
var wellKnownSymbol = __webpack_require__("fVMg");

var SPECIES = wellKnownSymbol('species');

// `ArraySpeciesCreate` abstract operation
// https://tc39.github.io/ecma262/#sec-arrayspeciescreate
module.exports = function (originalArray, length) {
  var C;
  if (isArray(originalArray)) {
    C = originalArray.constructor;
    // cross-realm fallback
    if (typeof C == 'function' && (C === Array || isArray(C.prototype))) C = undefined;
    else if (isObject(C)) {
      C = C[SPECIES];
      if (C === null) C = undefined;
    }
  } return new (C === undefined ? Array : C)(length === 0 ? 0 : length);
};


/***/ }),

/***/ "aokA":
/***/ (function(module, exports, __webpack_require__) {

var path = __webpack_require__("PjZX");
var has = __webpack_require__("8aeu");
var wrappedWellKnownSymbolModule = __webpack_require__("TkGI");
var defineProperty = __webpack_require__("q9+l").f;

module.exports = function (NAME) {
  var Symbol = path.Symbol || (path.Symbol = {});
  if (!has(Symbol, NAME)) defineProperty(Symbol, NAME, {
    value: wrappedWellKnownSymbolModule.f(NAME)
  });
};


/***/ }),

/***/ "aph7":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("KqXw");

__webpack_require__("Ysgh");

var _typeof = __webpack_require__("wiNy");

module.exports = deep;
module.exports.set = deepSet;

function deep(obj, address) {
  if (_typeof(obj) !== 'object') return;
  if (obj === null) return;
  var v = obj,
      parts = address.split('.');

  for (var i = 0; i < parts.length; i++) {
    if (typeof v[parts[i]] === 'undefined') return;
    if (v[parts[i]] === null) return;
    v = v[parts[i]];
  }

  return v;
}

function deepSet(obj, address, value) {
  if (_typeof(obj) !== 'object' || obj === null) return;
  var v = obj,
      parts = address.split('.'),
      leaf = parts.pop();

  for (var i = 0; i < parts.length; i++) {
    if (typeof v[parts[i]] === 'undefined') v[parts[i]] = {};
    v = v[parts[i]];
  }

  v[leaf] = value;
}

/***/ }),

/***/ "apkA":
/***/ (function(module, exports) {

var id = 0;
var postfix = Math.random();

module.exports = function (key) {
  return 'Symbol(' + String(key === undefined ? '' : key) + ')_' + (++id + postfix).toString(36);
};


/***/ }),

/***/ "avNT":
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__("n9AK");
var assign = __webpack_require__("cpF+");

// `Object.assign` method
// https://tc39.github.io/ecma262/#sec-object.assign
$({ target: 'Object', stat: true, forced: Object.assign !== assign }, {
  assign: assign
});


/***/ }),

/***/ "ax0f":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("9JhN");
var getOwnPropertyDescriptor = __webpack_require__("GFpt").f;
var createNonEnumerableProperty = __webpack_require__("WxKw");
var redefine = __webpack_require__("uLp7");
var setGlobal = __webpack_require__("PjRa");
var copyConstructorProperties = __webpack_require__("tjTa");
var isForced = __webpack_require__("66wQ");

/*
  options.target      - name of the target object
  options.global      - target is the global object
  options.stat        - export as static methods of target
  options.proto       - export as prototype methods of target
  options.real        - real prototype method for the `pure` version
  options.forced      - export even if the native feature is available
  options.bind        - bind methods to the target, required for the `pure` version
  options.wrap        - wrap constructors to preventing global pollution, required for the `pure` version
  options.unsafe      - use the simple assignment of property instead of delete + defineProperty
  options.sham        - add a flag to not completely full polyfills
  options.enumerable  - export as enumerable property
  options.noTargetGet - prevent calling a getter on target
*/
module.exports = function (options, source) {
  var TARGET = options.target;
  var GLOBAL = options.global;
  var STATIC = options.stat;
  var FORCED, target, key, targetProperty, sourceProperty, descriptor;
  if (GLOBAL) {
    target = global;
  } else if (STATIC) {
    target = global[TARGET] || setGlobal(TARGET, {});
  } else {
    target = (global[TARGET] || {}).prototype;
  }
  if (target) for (key in source) {
    sourceProperty = source[key];
    if (options.noTargetGet) {
      descriptor = getOwnPropertyDescriptor(target, key);
      targetProperty = descriptor && descriptor.value;
    } else targetProperty = target[key];
    FORCED = isForced(GLOBAL ? key : TARGET + (STATIC ? '.' : '#') + key, options.forced);
    // contained in target
    if (!FORCED && targetProperty !== undefined) {
      if (typeof sourceProperty === typeof targetProperty) continue;
      copyConstructorProperties(sourceProperty, targetProperty);
    }
    // add a flag to not completely full polyfills
    if (options.sham || (targetProperty && targetProperty.sham)) {
      createNonEnumerableProperty(sourceProperty, 'sham', true);
    }
    // extend global
    redefine(target, key, sourceProperty, options);
  }
};


/***/ }),

/***/ "b+9f":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("kjVY");

module.exports = parent;


/***/ }),

/***/ "b/Jy":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.asyncDispose` well-known symbol
// https://github.com/tc39/proposal-using-statement
defineWellKnownSymbol('asyncDispose');


/***/ }),

/***/ "bUrk":
/***/ (function(module, exports, __webpack_require__) {

var slice = __webpack_require__("uoFg");

var ArrayPrototype = Array.prototype;

module.exports = function (it) {
  var own = it.slice;
  return it === ArrayPrototype || (it instanceof Array && own === ArrayPrototype.slice) ? slice : own;
};


/***/ }),

/***/ "c9aA":
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__("5Jdw");
var propertyIsEnumerableModule = __webpack_require__("0foe");
var createPropertyDescriptor = __webpack_require__("96pp");
var toIndexedObject = __webpack_require__("VcbD");
var toPrimitive = __webpack_require__("3Mt6");
var has = __webpack_require__("zNvU");
var IE8_DOM_DEFINE = __webpack_require__("64g+");

var nativeGetOwnPropertyDescriptor = Object.getOwnPropertyDescriptor;

// `Object.getOwnPropertyDescriptor` method
// https://tc39.github.io/ecma262/#sec-object.getownpropertydescriptor
exports.f = DESCRIPTORS ? nativeGetOwnPropertyDescriptor : function getOwnPropertyDescriptor(O, P) {
  O = toIndexedObject(O);
  P = toPrimitive(P, true);
  if (IE8_DOM_DEFINE) try {
    return nativeGetOwnPropertyDescriptor(O, P);
  } catch (error) { /* empty */ }
  if (has(O, P)) return createPropertyDescriptor(!propertyIsEnumerableModule.f.call(O, P), O[P]);
};


/***/ }),

/***/ "cUqe":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("b+9f");

/***/ }),

/***/ "cY0r":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("avNT");
var path = __webpack_require__("j0PW");

module.exports = path.Object.assign;


/***/ }),

/***/ "cYYr":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var replace = String.prototype.replace;
var percentTwenties = /%20/g;

var util = __webpack_require__("V/Lb");

var Format = {
    RFC1738: 'RFC1738',
    RFC3986: 'RFC3986'
};

module.exports = util.assign(
    {
        'default': Format.RFC3986,
        formatters: {
            RFC1738: function (value) {
                return replace.call(value, percentTwenties, '+');
            },
            RFC3986: function (value) {
                return String(value);
            }
        }
    },
    Format
);


/***/ }),

/***/ "cpF+":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var DESCRIPTORS = __webpack_require__("5Jdw");
var fails = __webpack_require__("XU0c");
var objectKeys = __webpack_require__("nKVx");
var getOwnPropertySymbolsModule = __webpack_require__("iYt3");
var propertyIsEnumerableModule = __webpack_require__("0foe");
var toObject = __webpack_require__("quhl");
var IndexedObject = __webpack_require__("fDXD");

var nativeAssign = Object.assign;
var defineProperty = Object.defineProperty;

// `Object.assign` method
// https://tc39.github.io/ecma262/#sec-object.assign
module.exports = !nativeAssign || fails(function () {
  // should have correct order of operations (Edge bug)
  if (DESCRIPTORS && nativeAssign({ b: 1 }, nativeAssign(defineProperty({}, 'a', {
    enumerable: true,
    get: function () {
      defineProperty(this, 'b', {
        value: 3,
        enumerable: false
      });
    }
  }), { b: 2 })).b !== 1) return true;
  // should work with symbols and should have deterministic property order (V8 bug)
  var A = {};
  var B = {};
  // eslint-disable-next-line no-undef
  var symbol = Symbol();
  var alphabet = 'abcdefghijklmnopqrst';
  A[symbol] = 7;
  alphabet.split('').forEach(function (chr) { B[chr] = chr; });
  return nativeAssign({}, A)[symbol] != 7 || objectKeys(nativeAssign({}, B)).join('') != alphabet;
}) ? function assign(target, source) { // eslint-disable-line no-unused-vars
  var T = toObject(target);
  var argumentsLength = arguments.length;
  var index = 1;
  var getOwnPropertySymbols = getOwnPropertySymbolsModule.f;
  var propertyIsEnumerable = propertyIsEnumerableModule.f;
  while (argumentsLength > index) {
    var S = IndexedObject(arguments[index++]);
    var keys = getOwnPropertySymbols ? objectKeys(S).concat(getOwnPropertySymbols(S)) : objectKeys(S);
    var length = keys.length;
    var j = 0;
    var key;
    while (length > j) {
      key = keys[j++];
      if (!DESCRIPTORS || propertyIsEnumerable.call(S, key)) T[key] = S[key];
    }
  } return T;
} : nativeAssign;


/***/ }),

/***/ "cpcO":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("9JhN");
var inspectSource = __webpack_require__("32/0");

var WeakMap = global.WeakMap;

module.exports = typeof WeakMap === 'function' && /native code/.test(inspectSource(WeakMap));


/***/ }),

/***/ "ct80":
/***/ (function(module, exports) {

module.exports = function (exec) {
  try {
    return !!exec();
  } catch (error) {
    return true;
  }
};


/***/ }),

/***/ "cww3":
/***/ (function(module, exports) {

// `RequireObjectCoercible` abstract operation
// https://tc39.github.io/ecma262/#sec-requireobjectcoercible
module.exports = function (it) {
  if (it == undefined) throw TypeError("Can't call method on " + it);
  return it;
};


/***/ }),

/***/ "dLyh":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("n9AK");
var isObject = __webpack_require__("H3h0");
var isArray = __webpack_require__("ygwS");
var toAbsoluteIndex = __webpack_require__("Nj2W");
var toLength = __webpack_require__("Gpqx");
var toIndexedObject = __webpack_require__("VcbD");
var createProperty = __webpack_require__("1FCb");
var wellKnownSymbol = __webpack_require__("HVcX");
var arrayMethodHasSpeciesSupport = __webpack_require__("nB+7");
var arrayMethodUsesToLength = __webpack_require__("ocDp");

var HAS_SPECIES_SUPPORT = arrayMethodHasSpeciesSupport('slice');
var USES_TO_LENGTH = arrayMethodUsesToLength('slice', { ACCESSORS: true, 0: 0, 1: 2 });

var SPECIES = wellKnownSymbol('species');
var nativeSlice = [].slice;
var max = Math.max;

// `Array.prototype.slice` method
// https://tc39.github.io/ecma262/#sec-array.prototype.slice
// fallback for not array-like ES3 strings and DOM objects
$({ target: 'Array', proto: true, forced: !HAS_SPECIES_SUPPORT || !USES_TO_LENGTH }, {
  slice: function slice(start, end) {
    var O = toIndexedObject(this);
    var length = toLength(O.length);
    var k = toAbsoluteIndex(start, length);
    var fin = toAbsoluteIndex(end === undefined ? length : end, length);
    // inline `ArraySpeciesCreate` for usage native `Array#slice` where it's possible
    var Constructor, result, n;
    if (isArray(O)) {
      Constructor = O.constructor;
      // cross-realm fallback
      if (typeof Constructor == 'function' && (Constructor === Array || isArray(Constructor.prototype))) {
        Constructor = undefined;
      } else if (isObject(Constructor)) {
        Constructor = Constructor[SPECIES];
        if (Constructor === null) Constructor = undefined;
      }
      if (Constructor === Array || Constructor === undefined) {
        return nativeSlice.call(O, k, fin);
      }
    }
    result = new (Constructor === undefined ? Array : Constructor)(max(fin - k, 0));
    for (n = 0; k < fin; k++, n++) if (k in O) createProperty(result, n, O[k]);
    result.length = n;
    return result;
  }
});


/***/ }),

/***/ "dSaG":
/***/ (function(module, exports) {

module.exports = function (it) {
  return typeof it === 'object' ? it !== null : typeof it === 'function';
};


/***/ }),

/***/ "dU17":
/***/ (function(module, exports, __webpack_require__) {

var setToStringTag = __webpack_require__("CtlU");

// Math[@@toStringTag] property
// https://tc39.github.io/ecma262/#sec-math-@@tostringtag
setToStringTag(Math, 'Math', true);


/***/ }),

/***/ "eDnP":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("VQ32");

/***/ }),

/***/ "eLIV":
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__("XU0c");
var whitespaces = __webpack_require__("3sPw");

var non = '\u200B\u0085\u180E';

// check that a method works with the correct list
// of whitespaces and has a correct name
module.exports = function (METHOD_NAME) {
  return fails(function () {
    return !!whitespaces[METHOD_NAME]() || non[METHOD_NAME]() != non || whitespaces[METHOD_NAME].name !== METHOD_NAME;
  });
};


/***/ }),

/***/ "eOXo":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("YkBG");

module.exports = parent;


/***/ }),

/***/ "espU":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("wkL6");

/***/ }),

/***/ "f4p7":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var fails = __webpack_require__("ct80");

module.exports = function (METHOD_NAME, argument) {
  var method = [][METHOD_NAME];
  return !!method && fails(function () {
    // eslint-disable-next-line no-useless-call,no-throw-literal
    method.call(null, argument || function () { throw 1; }, 1);
  });
};


/***/ }),

/***/ "fD9S":
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__("1Mu/");
var fails = __webpack_require__("ct80");
var createElement = __webpack_require__("8r/q");

// Thank's IE8 for his funny defineProperty
module.exports = !DESCRIPTORS && !fails(function () {
  return Object.defineProperty(createElement('div'), 'a', {
    get: function () { return 7; }
  }).a != 7;
});


/***/ }),

/***/ "fDXD":
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__("XU0c");
var classof = __webpack_require__("WTd3");

var split = ''.split;

// fallback for non-array-like ES3 and non-enumerable old V8 strings
module.exports = fails(function () {
  // throws an error in rhino, see https://github.com/mozilla/rhino/issues/346
  // eslint-disable-next-line no-prototype-builtins
  return !Object('z').propertyIsEnumerable(0);
}) ? function (it) {
  return classof(it) == 'String' ? split.call(it, '') : Object(it);
} : Object;


/***/ }),

/***/ "fRV1":
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || new Function("return this")();
} catch (e) {
	// This works if the window reference is available
	if (typeof window === "object") g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),

/***/ "fVMg":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("9JhN");
var shared = __webpack_require__("TN3B");
var has = __webpack_require__("8aeu");
var uid = __webpack_require__("HYrn");
var NATIVE_SYMBOL = __webpack_require__("56Cj");
var USE_SYMBOL_AS_UID = __webpack_require__("TbR9");

var WellKnownSymbolsStore = shared('wks');
var Symbol = global.Symbol;
var createWellKnownSymbol = USE_SYMBOL_AS_UID ? Symbol : Symbol && Symbol.withoutSetter || uid;

module.exports = function (name) {
  if (!has(WellKnownSymbolsStore, name)) {
    if (NATIVE_SYMBOL && has(Symbol, name)) WellKnownSymbolsStore[name] = Symbol[name];
    else WellKnownSymbolsStore[name] = createWellKnownSymbol('Symbol.' + name);
  } return WellKnownSymbolsStore[name];
};


/***/ }),

/***/ "fZb7":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

// EXPORTS
__webpack_require__.d(__webpack_exports__, "TYPE", function() { return /* reexport */ types["b" /* TYPE */]; });
__webpack_require__.d(__webpack_exports__, "SKELETON_TYPE", function() { return /* reexport */ types["a" /* SKELETON_TYPE */]; });
__webpack_require__.d(__webpack_exports__, "isLiteralElement", function() { return /* reexport */ types["h" /* isLiteralElement */]; });
__webpack_require__.d(__webpack_exports__, "isArgumentElement", function() { return /* reexport */ types["e" /* isArgumentElement */]; });
__webpack_require__.d(__webpack_exports__, "isNumberElement", function() { return /* reexport */ types["i" /* isNumberElement */]; });
__webpack_require__.d(__webpack_exports__, "isDateElement", function() { return /* reexport */ types["f" /* isDateElement */]; });
__webpack_require__.d(__webpack_exports__, "isTimeElement", function() { return /* reexport */ types["o" /* isTimeElement */]; });
__webpack_require__.d(__webpack_exports__, "isSelectElement", function() { return /* reexport */ types["m" /* isSelectElement */]; });
__webpack_require__.d(__webpack_exports__, "isPluralElement", function() { return /* reexport */ types["k" /* isPluralElement */]; });
__webpack_require__.d(__webpack_exports__, "isPoundElement", function() { return /* reexport */ types["l" /* isPoundElement */]; });
__webpack_require__.d(__webpack_exports__, "isTagElement", function() { return /* reexport */ types["n" /* isTagElement */]; });
__webpack_require__.d(__webpack_exports__, "isNumberSkeleton", function() { return /* reexport */ types["j" /* isNumberSkeleton */]; });
__webpack_require__.d(__webpack_exports__, "isDateTimeSkeleton", function() { return /* reexport */ types["g" /* isDateTimeSkeleton */]; });
__webpack_require__.d(__webpack_exports__, "createLiteralElement", function() { return /* reexport */ types["c" /* createLiteralElement */]; });
__webpack_require__.d(__webpack_exports__, "createNumberElement", function() { return /* reexport */ types["d" /* createNumberElement */]; });
__webpack_require__.d(__webpack_exports__, "SyntaxError", function() { return /* reexport */ parser_SyntaxError; });
__webpack_require__.d(__webpack_exports__, "pegParse", function() { return /* reexport */ pegParse; });
__webpack_require__.d(__webpack_exports__, "parseDateTimeSkeleton", function() { return /* reexport */ skeleton["b" /* parseDateTimeSkeleton */]; });
__webpack_require__.d(__webpack_exports__, "convertNumberSkeletonToNumberFormatOptions", function() { return /* reexport */ skeleton["a" /* convertNumberSkeletonToNumberFormatOptions */]; });
__webpack_require__.d(__webpack_exports__, "parse", function() { return /* binding */ parse; });

// EXTERNAL MODULE: /home/kaore/Dev/lib/oa/node_modules/core-js/modules/es.symbol.js
var es_symbol = __webpack_require__("1t7P");

// EXTERNAL MODULE: /home/kaore/Dev/lib/oa/node_modules/core-js/modules/es.symbol.description.js
var es_symbol_description = __webpack_require__("jQ/y");

// EXTERNAL MODULE: /home/kaore/Dev/lib/oa/node_modules/core-js/modules/es.array.join.js
var es_array_join = __webpack_require__("7xRU");

// EXTERNAL MODULE: /home/kaore/Dev/lib/oa/node_modules/core-js/modules/es.function.name.js
var es_function_name = __webpack_require__("ho0z");

// EXTERNAL MODULE: /home/kaore/Dev/lib/oa/node_modules/core-js/modules/es.object.to-string.js
var es_object_to_string = __webpack_require__("7x/C");

// EXTERNAL MODULE: /home/kaore/Dev/lib/oa/node_modules/core-js/modules/es.regexp.exec.js
var es_regexp_exec = __webpack_require__("KqXw");

// EXTERNAL MODULE: /home/kaore/Dev/lib/oa/node_modules/core-js/modules/es.regexp.to-string.js
var es_regexp_to_string = __webpack_require__("DZ+c");

// EXTERNAL MODULE: /home/kaore/Dev/lib/oa/node_modules/core-js/modules/es.string.replace.js
var es_string_replace = __webpack_require__("MvUL");

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/parse-int.js
var parse_int = __webpack_require__("5Uch");
var parse_int_default = /*#__PURE__*/__webpack_require__.n(parse_int);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/instance/reduce.js
var reduce = __webpack_require__("XSsT");
var reduce_default = /*#__PURE__*/__webpack_require__.n(reduce);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/instance/slice.js
var slice = __webpack_require__("PBoD");
var slice_default = /*#__PURE__*/__webpack_require__.n(slice);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/instance/sort.js
var sort = __webpack_require__("GwNf");
var sort_default = /*#__PURE__*/__webpack_require__.n(sort);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/array/is-array.js
var is_array = __webpack_require__("1A8d");
var is_array_default = /*#__PURE__*/__webpack_require__.n(is_array);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/instance/map.js
var map = __webpack_require__("VluA");
var map_default = /*#__PURE__*/__webpack_require__.n(map);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/object/assign.js
var object_assign = __webpack_require__("kpPl");
var assign_default = /*#__PURE__*/__webpack_require__.n(object_assign);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/object/create.js
var create = __webpack_require__("UwuC");
var create_default = /*#__PURE__*/__webpack_require__.n(create);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/object/set-prototype-of.js
var set_prototype_of = __webpack_require__("tfi8");
var set_prototype_of_default = /*#__PURE__*/__webpack_require__.n(set_prototype_of);

// EXTERNAL MODULE: ../labels/node_modules/intl-messageformat-parser/lib/types.js
var types = __webpack_require__("CHFT");

// CONCATENATED MODULE: ../labels/node_modules/intl-messageformat-parser/lib/parser.js


















// tslint:disable:only-arrow-functions
// tslint:disable:object-literal-shorthand
// tslint:disable:trailing-comma
// tslint:disable:object-literal-sort-keys
// tslint:disable:one-variable-per-declaration
// tslint:disable:max-line-length
// tslint:disable:no-consecutive-blank-lines
// tslint:disable:align
var __extends = undefined && undefined.__extends || function () {
  var _extendStatics = function extendStatics(d, b) {
    _extendStatics = set_prototype_of_default.a || {
      __proto__: []
    } instanceof Array && function (d, b) {
      d.__proto__ = b;
    } || function (d, b) {
      for (var p in b) {
        if (b.hasOwnProperty(p)) d[p] = b[p];
      }
    };

    return _extendStatics(d, b);
  };

  return function (d, b) {
    _extendStatics(d, b);

    function __() {
      this.constructor = d;
    }

    d.prototype = b === null ? create_default()(b) : (__.prototype = b.prototype, new __());
  };
}();

var __assign = undefined && undefined.__assign || function () {
  __assign = assign_default.a || function (t) {
    for (var s, i = 1, n = arguments.length; i < n; i++) {
      s = arguments[i];

      for (var p in s) {
        if (Object.prototype.hasOwnProperty.call(s, p)) t[p] = s[p];
      }
    }

    return t;
  };

  return __assign.apply(this, arguments);
}; // Generated by PEG.js v. 0.10.0 (ts-pegjs plugin v. 0.2.6 )
//
// https://pegjs.org/   https://github.com/metadevpro/ts-pegjs




var parser_SyntaxError =
/** @class */
function (_super) {
  __extends(SyntaxError, _super);

  function SyntaxError(message, expected, found, location) {
    var _this = _super.call(this) || this;

    _this.message = message;
    _this.expected = expected;
    _this.found = found;
    _this.location = location;
    _this.name = "SyntaxError";

    if (typeof Error.captureStackTrace === "function") {
      Error.captureStackTrace(_this, SyntaxError);
    }

    return _this;
  }

  SyntaxError.buildMessage = function (expected, found) {
    function hex(ch) {
      return ch.charCodeAt(0).toString(16).toUpperCase();
    }

    function literalEscape(s) {
      return s.replace(/\\/g, "\\\\").replace(/"/g, "\\\"").replace(/\0/g, "\\0").replace(/\t/g, "\\t").replace(/\n/g, "\\n").replace(/\r/g, "\\r").replace(/[\x00-\x0F]/g, function (ch) {
        return "\\x0" + hex(ch);
      }).replace(/[\x10-\x1F\x7F-\x9F]/g, function (ch) {
        return "\\x" + hex(ch);
      });
    }

    function classEscape(s) {
      return s.replace(/\\/g, "\\\\").replace(/\]/g, "\\]").replace(/\^/g, "\\^").replace(/-/g, "\\-").replace(/\0/g, "\\0").replace(/\t/g, "\\t").replace(/\n/g, "\\n").replace(/\r/g, "\\r").replace(/[\x00-\x0F]/g, function (ch) {
        return "\\x0" + hex(ch);
      }).replace(/[\x10-\x1F\x7F-\x9F]/g, function (ch) {
        return "\\x" + hex(ch);
      });
    }

    function describeExpectation(expectation) {
      var _context;

      switch (expectation.type) {
        case "literal":
          return "\"" + literalEscape(expectation.text) + "\"";

        case "class":
          var escapedParts = map_default()(_context = expectation.parts).call(_context, function (part) {
            return is_array_default()(part) ? classEscape(part[0]) + "-" + classEscape(part[1]) : classEscape(part);
          });

          return "[" + (expectation.inverted ? "^" : "") + escapedParts + "]";

        case "any":
          return "any character";

        case "end":
          return "end of input";

        case "other":
          return expectation.description;
      }
    }

    function describeExpected(expected1) {
      var descriptions = map_default()(expected1).call(expected1, describeExpectation);

      var i;
      var j;

      sort_default()(descriptions).call(descriptions);

      if (descriptions.length > 0) {
        for (i = 1, j = 1; i < descriptions.length; i++) {
          if (descriptions[i - 1] !== descriptions[i]) {
            descriptions[j] = descriptions[i];
            j++;
          }
        }

        descriptions.length = j;
      }

      switch (descriptions.length) {
        case 1:
          return descriptions[0];

        case 2:
          return descriptions[0] + " or " + descriptions[1];

        default:
          return slice_default()(descriptions).call(descriptions, 0, -1).join(", ") + ", or " + descriptions[descriptions.length - 1];
      }
    }

    function describeFound(found1) {
      return found1 ? "\"" + literalEscape(found1) + "\"" : "end of input";
    }

    return "Expected " + describeExpected(expected) + " but " + describeFound(found) + " found.";
  };

  return SyntaxError;
}(Error);



function peg$parse(input, options) {
  options = options !== undefined ? options : {};
  var peg$FAILED = {};
  var peg$startRuleFunctions = {
    start: peg$parsestart
  };
  var peg$startRuleFunction = peg$parsestart;

  var peg$c0 = function peg$c0(parts) {
    return parts.join('');
  };

  var peg$c1 = function peg$c1(messageText) {
    return __assign({
      type: types["b" /* TYPE */].literal,
      value: messageText
    }, insertLocation());
  };

  var peg$c2 = "#";
  var peg$c3 = peg$literalExpectation("#", false);

  var peg$c4 = function peg$c4() {
    return __assign({
      type: types["b" /* TYPE */].pound
    }, insertLocation());
  };

  var peg$c5 = peg$otherExpectation("tagElement");
  var peg$c6 = "<";
  var peg$c7 = peg$literalExpectation("<", false);
  var peg$c8 = "/>";
  var peg$c9 = peg$literalExpectation("/>", false);

  var peg$c10 = function peg$c10(value) {
    return __assign({
      type: types["b" /* TYPE */].literal,
      value: value.join('')
    }, insertLocation());
  };

  var peg$c11 = function peg$c11(open, children, close) {
    if (open !== close) {
      error("Mismatch tag \"" + open + "\" !== \"" + close + "\"", location());
    }

    return __assign({
      type: types["b" /* TYPE */].tag,
      value: open,
      children: children
    }, insertLocation());
  };

  var peg$c12 = function peg$c12() {
    messageCtx.push('openingTag');
    return true;
  };

  var peg$c13 = ">";
  var peg$c14 = peg$literalExpectation(">", false);

  var peg$c15 = function peg$c15(tag) {
    messageCtx.pop();
    return true;
  };

  var peg$c16 = function peg$c16(tag) {
    return tag;
  };

  var peg$c17 = "</";
  var peg$c18 = peg$literalExpectation("</", false);

  var peg$c19 = function peg$c19() {
    messageCtx.push('closingTag');
    return true;
  };

  var peg$c20 = peg$otherExpectation("argumentElement");
  var peg$c21 = "{";
  var peg$c22 = peg$literalExpectation("{", false);
  var peg$c23 = "}";
  var peg$c24 = peg$literalExpectation("}", false);

  var peg$c25 = function peg$c25(value) {
    return __assign({
      type: types["b" /* TYPE */].argument,
      value: value
    }, insertLocation());
  };

  var peg$c26 = peg$otherExpectation("numberSkeletonId");
  var peg$c27 = /^['\/{}]/;
  var peg$c28 = peg$classExpectation(["'", "/", "{", "}"], false, false);
  var peg$c29 = peg$anyExpectation();
  var peg$c30 = peg$otherExpectation("numberSkeletonTokenOption");
  var peg$c31 = "/";
  var peg$c32 = peg$literalExpectation("/", false);

  var peg$c33 = function peg$c33(option) {
    return option;
  };

  var peg$c34 = peg$otherExpectation("numberSkeletonToken");

  var peg$c35 = function peg$c35(stem, options) {
    return {
      stem: stem,
      options: options
    };
  };

  var peg$c36 = function peg$c36(tokens) {
    return __assign({
      type: 0
      /* number */
      ,
      tokens: tokens
    }, insertLocation());
  };

  var peg$c37 = "::";
  var peg$c38 = peg$literalExpectation("::", false);

  var peg$c39 = function peg$c39(skeleton) {
    return skeleton;
  };

  var peg$c40 = function peg$c40() {
    messageCtx.push('numberArgStyle');
    return true;
  };

  var peg$c41 = function peg$c41(style) {
    messageCtx.pop();
    return style.replace(/\s*$/, '');
  };

  var peg$c42 = ",";
  var peg$c43 = peg$literalExpectation(",", false);
  var peg$c44 = "number";
  var peg$c45 = peg$literalExpectation("number", false);

  var peg$c46 = function peg$c46(value, type, style) {
    return __assign({
      type: type === 'number' ? types["b" /* TYPE */].number : type === 'date' ? types["b" /* TYPE */].date : types["b" /* TYPE */].time,
      style: style && style[2],
      value: value
    }, insertLocation());
  };

  var peg$c47 = "'";
  var peg$c48 = peg$literalExpectation("'", false);
  var peg$c49 = /^[^']/;
  var peg$c50 = peg$classExpectation(["'"], true, false);
  var peg$c51 = /^[^a-zA-Z'{}]/;
  var peg$c52 = peg$classExpectation([["a", "z"], ["A", "Z"], "'", "{", "}"], true, false);
  var peg$c53 = /^[a-zA-Z]/;
  var peg$c54 = peg$classExpectation([["a", "z"], ["A", "Z"]], false, false);

  var peg$c55 = function peg$c55(pattern) {
    return __assign({
      type: 1
      /* dateTime */
      ,
      pattern: pattern
    }, insertLocation());
  };

  var peg$c56 = function peg$c56() {
    messageCtx.push('dateOrTimeArgStyle');
    return true;
  };

  var peg$c57 = "date";
  var peg$c58 = peg$literalExpectation("date", false);
  var peg$c59 = "time";
  var peg$c60 = peg$literalExpectation("time", false);
  var peg$c61 = "plural";
  var peg$c62 = peg$literalExpectation("plural", false);
  var peg$c63 = "selectordinal";
  var peg$c64 = peg$literalExpectation("selectordinal", false);
  var peg$c65 = "offset:";
  var peg$c66 = peg$literalExpectation("offset:", false);

  var peg$c67 = function peg$c67(value, pluralType, offset, options) {
    return __assign({
      type: types["b" /* TYPE */].plural,
      pluralType: pluralType === 'plural' ? 'cardinal' : 'ordinal',
      value: value,
      offset: offset ? offset[2] : 0,
      options: reduce_default()(options).call(options, function (all, _a) {
        var id = _a.id,
            value = _a.value,
            optionLocation = _a.location;

        if (id in all) {
          error("Duplicate option \"" + id + "\" in plural element: \"" + text() + "\"", location());
        }

        all[id] = {
          value: value,
          location: optionLocation
        };
        return all;
      }, {})
    }, insertLocation());
  };

  var peg$c68 = "select";
  var peg$c69 = peg$literalExpectation("select", false);

  var peg$c70 = function peg$c70(value, options) {
    return __assign({
      type: types["b" /* TYPE */].select,
      value: value,
      options: reduce_default()(options).call(options, function (all, _a) {
        var id = _a.id,
            value = _a.value,
            optionLocation = _a.location;

        if (id in all) {
          error("Duplicate option \"" + id + "\" in select element: \"" + text() + "\"", location());
        }

        all[id] = {
          value: value,
          location: optionLocation
        };
        return all;
      }, {})
    }, insertLocation());
  };

  var peg$c71 = "=";
  var peg$c72 = peg$literalExpectation("=", false);

  var peg$c73 = function peg$c73(id) {
    messageCtx.push('select');
    return true;
  };

  var peg$c74 = function peg$c74(id, value) {
    messageCtx.pop();
    return __assign({
      id: id,
      value: value
    }, insertLocation());
  };

  var peg$c75 = function peg$c75(id) {
    messageCtx.push('plural');
    return true;
  };

  var peg$c76 = function peg$c76(id, value) {
    messageCtx.pop();
    return __assign({
      id: id,
      value: value
    }, insertLocation());
  };

  var peg$c77 = peg$otherExpectation("whitespace");
  var peg$c78 = /^[\t-\r \x85\xA0\u1680\u2000-\u200A\u2028\u2029\u202F\u205F\u3000]/;
  var peg$c79 = peg$classExpectation([["\t", "\r"], " ", "\x85", "\xA0", "\u1680", ["\u2000", "\u200A"], "\u2028", "\u2029", "\u202F", "\u205F", "\u3000"], false, false);
  var peg$c80 = peg$otherExpectation("syntax pattern");
  var peg$c81 = /^[!-\/:-@[-\^`{-~\xA1-\xA7\xA9\xAB\xAC\xAE\xB0\xB1\xB6\xBB\xBF\xD7\xF7\u2010-\u2027\u2030-\u203E\u2041-\u2053\u2055-\u205E\u2190-\u245F\u2500-\u2775\u2794-\u2BFF\u2E00-\u2E7F\u3001-\u3003\u3008-\u3020\u3030\uFD3E\uFD3F\uFE45\uFE46]/;
  var peg$c82 = peg$classExpectation([["!", "/"], [":", "@"], ["[", "^"], "`", ["{", "~"], ["\xA1", "\xA7"], "\xA9", "\xAB", "\xAC", "\xAE", "\xB0", "\xB1", "\xB6", "\xBB", "\xBF", "\xD7", "\xF7", ["\u2010", "\u2027"], ["\u2030", "\u203E"], ["\u2041", "\u2053"], ["\u2055", "\u205E"], ["\u2190", "\u245F"], ["\u2500", "\u2775"], ["\u2794", "\u2BFF"], ["\u2E00", "\u2E7F"], ["\u3001", "\u3003"], ["\u3008", "\u3020"], "\u3030", "\uFD3E", "\uFD3F", "\uFE45", "\uFE46"], false, false);
  var peg$c83 = peg$otherExpectation("optional whitespace");
  var peg$c84 = peg$otherExpectation("number");
  var peg$c85 = "-";
  var peg$c86 = peg$literalExpectation("-", false);

  var peg$c87 = function peg$c87(negative, num) {
    return num ? negative ? -num : num : 0;
  };

  var peg$c88 = peg$otherExpectation("apostrophe");
  var peg$c89 = peg$otherExpectation("double apostrophes");
  var peg$c90 = "''";
  var peg$c91 = peg$literalExpectation("''", false);

  var peg$c92 = function peg$c92() {
    return "'";
  };

  var peg$c93 = function peg$c93(escapedChar, quotedChars) {
    return escapedChar + quotedChars.replace("''", "'");
  };

  var peg$c94 = function peg$c94(x) {
    return (ignoreTag() || x !== '<') && x !== '{' && !(isInPluralOption() && x === '#') && !(isNestedMessageText() && x === '}') && !(!ignoreTag() && isNestedMessageText() && x === '>');
  };

  var peg$c95 = "\n";
  var peg$c96 = peg$literalExpectation("\n", false);

  var peg$c97 = function peg$c97(x) {
    return x === '<' || x === '>' || x === '{' || x === '}' || isInPluralOption() && x === '#';
  };

  var peg$c98 = peg$otherExpectation("argNameOrNumber");
  var peg$c99 = peg$otherExpectation("validTag");
  var peg$c100 = peg$otherExpectation("argNumber");
  var peg$c101 = "0";
  var peg$c102 = peg$literalExpectation("0", false);

  var peg$c103 = function peg$c103() {
    return 0;
  };

  var peg$c104 = /^[1-9]/;
  var peg$c105 = peg$classExpectation([["1", "9"]], false, false);
  var peg$c106 = /^[0-9]/;
  var peg$c107 = peg$classExpectation([["0", "9"]], false, false);

  var peg$c108 = function peg$c108(digits) {
    return parse_int_default()(digits.join(''), 10);
  };

  var peg$c109 = peg$otherExpectation("argName");
  var peg$c110 = peg$otherExpectation("tagName");
  var peg$currPos = 0;
  var peg$savedPos = 0;
  var peg$posDetailsCache = [{
    line: 1,
    column: 1
  }];
  var peg$maxFailPos = 0;
  var peg$maxFailExpected = [];
  var peg$silentFails = 0;
  var peg$result;

  if (options.startRule !== undefined) {
    if (!(options.startRule in peg$startRuleFunctions)) {
      throw new Error("Can't start parsing from rule \"" + options.startRule + "\".");
    }

    peg$startRuleFunction = peg$startRuleFunctions[options.startRule];
  }

  function text() {
    return input.substring(peg$savedPos, peg$currPos);
  }

  function location() {
    return peg$computeLocation(peg$savedPos, peg$currPos);
  }

  function expected(description, location1) {
    location1 = location1 !== undefined ? location1 : peg$computeLocation(peg$savedPos, peg$currPos);
    throw peg$buildStructuredError([peg$otherExpectation(description)], input.substring(peg$savedPos, peg$currPos), location1);
  }

  function error(message, location1) {
    location1 = location1 !== undefined ? location1 : peg$computeLocation(peg$savedPos, peg$currPos);
    throw peg$buildSimpleError(message, location1);
  }

  function peg$literalExpectation(text1, ignoreCase) {
    return {
      type: "literal",
      text: text1,
      ignoreCase: ignoreCase
    };
  }

  function peg$classExpectation(parts, inverted, ignoreCase) {
    return {
      type: "class",
      parts: parts,
      inverted: inverted,
      ignoreCase: ignoreCase
    };
  }

  function peg$anyExpectation() {
    return {
      type: "any"
    };
  }

  function peg$endExpectation() {
    return {
      type: "end"
    };
  }

  function peg$otherExpectation(description) {
    return {
      type: "other",
      description: description
    };
  }

  function peg$computePosDetails(pos) {
    var details = peg$posDetailsCache[pos];
    var p;

    if (details) {
      return details;
    } else {
      p = pos - 1;

      while (!peg$posDetailsCache[p]) {
        p--;
      }

      details = peg$posDetailsCache[p];
      details = {
        line: details.line,
        column: details.column
      };

      while (p < pos) {
        if (input.charCodeAt(p) === 10) {
          details.line++;
          details.column = 1;
        } else {
          details.column++;
        }

        p++;
      }

      peg$posDetailsCache[pos] = details;
      return details;
    }
  }

  function peg$computeLocation(startPos, endPos) {
    var startPosDetails = peg$computePosDetails(startPos);
    var endPosDetails = peg$computePosDetails(endPos);
    return {
      start: {
        offset: startPos,
        line: startPosDetails.line,
        column: startPosDetails.column
      },
      end: {
        offset: endPos,
        line: endPosDetails.line,
        column: endPosDetails.column
      }
    };
  }

  function peg$fail(expected1) {
    if (peg$currPos < peg$maxFailPos) {
      return;
    }

    if (peg$currPos > peg$maxFailPos) {
      peg$maxFailPos = peg$currPos;
      peg$maxFailExpected = [];
    }

    peg$maxFailExpected.push(expected1);
  }

  function peg$buildSimpleError(message, location1) {
    return new parser_SyntaxError(message, [], "", location1);
  }

  function peg$buildStructuredError(expected1, found, location1) {
    return new parser_SyntaxError(parser_SyntaxError.buildMessage(expected1, found), expected1, found, location1);
  }

  function peg$parsestart() {
    var s0;
    s0 = peg$parsemessage();
    return s0;
  }

  function peg$parsemessage() {
    var s0, s1;
    s0 = [];
    s1 = peg$parsemessageElement();

    while (s1 !== peg$FAILED) {
      s0.push(s1);
      s1 = peg$parsemessageElement();
    }

    return s0;
  }

  function peg$parsemessageElement() {
    var s0;
    s0 = peg$parseliteralElement();

    if (s0 === peg$FAILED) {
      s0 = peg$parseargumentElement();

      if (s0 === peg$FAILED) {
        s0 = peg$parsesimpleFormatElement();

        if (s0 === peg$FAILED) {
          s0 = peg$parsepluralElement();

          if (s0 === peg$FAILED) {
            s0 = peg$parseselectElement();

            if (s0 === peg$FAILED) {
              s0 = peg$parsetagElement();

              if (s0 === peg$FAILED) {
                s0 = peg$parsepoundElement();
              }
            }
          }
        }
      }
    }

    return s0;
  }

  function peg$parsemessageText() {
    var s0, s1, s2;
    s0 = peg$currPos;
    s1 = [];
    s2 = peg$parsedoubleApostrophes();

    if (s2 === peg$FAILED) {
      s2 = peg$parsequotedString();

      if (s2 === peg$FAILED) {
        s2 = peg$parseunquotedString();
      }
    }

    if (s2 !== peg$FAILED) {
      while (s2 !== peg$FAILED) {
        s1.push(s2);
        s2 = peg$parsedoubleApostrophes();

        if (s2 === peg$FAILED) {
          s2 = peg$parsequotedString();

          if (s2 === peg$FAILED) {
            s2 = peg$parseunquotedString();
          }
        }
      }
    } else {
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      peg$savedPos = s0;
      s1 = peg$c0(s1);
    }

    s0 = s1;
    return s0;
  }

  function peg$parseliteralElement() {
    var s0, s1;
    s0 = peg$currPos;
    s1 = peg$parsemessageText();

    if (s1 !== peg$FAILED) {
      peg$savedPos = s0;
      s1 = peg$c1(s1);
    }

    s0 = s1;
    return s0;
  }

  function peg$parsepoundElement() {
    var s0, s1;
    s0 = peg$currPos;

    if (input.charCodeAt(peg$currPos) === 35) {
      s1 = peg$c2;
      peg$currPos++;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c3);
      }
    }

    if (s1 !== peg$FAILED) {
      peg$savedPos = s0;
      s1 = peg$c4();
    }

    s0 = s1;
    return s0;
  }

  function peg$parsetagElement() {
    var s0, s1, s2, s3, s4, s5;
    peg$silentFails++;
    s0 = peg$currPos;
    s1 = peg$currPos;

    if (input.charCodeAt(peg$currPos) === 60) {
      s2 = peg$c6;
      peg$currPos++;
    } else {
      s2 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c7);
      }
    }

    if (s2 !== peg$FAILED) {
      s3 = peg$parsevalidTag();

      if (s3 !== peg$FAILED) {
        s4 = peg$parse_();

        if (s4 !== peg$FAILED) {
          if (input.substr(peg$currPos, 2) === peg$c8) {
            s5 = peg$c8;
            peg$currPos += 2;
          } else {
            s5 = peg$FAILED;

            if (peg$silentFails === 0) {
              peg$fail(peg$c9);
            }
          }

          if (s5 !== peg$FAILED) {
            s2 = [s2, s3, s4, s5];
            s1 = s2;
          } else {
            peg$currPos = s1;
            s1 = peg$FAILED;
          }
        } else {
          peg$currPos = s1;
          s1 = peg$FAILED;
        }
      } else {
        peg$currPos = s1;
        s1 = peg$FAILED;
      }
    } else {
      peg$currPos = s1;
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      peg$savedPos = s0;
      s1 = peg$c10(s1);
    }

    s0 = s1;

    if (s0 === peg$FAILED) {
      s0 = peg$currPos;
      s1 = peg$parseopeningTag();

      if (s1 !== peg$FAILED) {
        s2 = peg$parsemessage();

        if (s2 !== peg$FAILED) {
          s3 = peg$parseclosingTag();

          if (s3 !== peg$FAILED) {
            peg$savedPos = s0;
            s1 = peg$c11(s1, s2, s3);
            s0 = s1;
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c5);
      }
    }

    return s0;
  }

  function peg$parseopeningTag() {
    var s0, s1, s2, s3, s4, s5;
    s0 = peg$currPos;

    if (input.charCodeAt(peg$currPos) === 60) {
      s1 = peg$c6;
      peg$currPos++;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c7);
      }
    }

    if (s1 !== peg$FAILED) {
      peg$savedPos = peg$currPos;
      s2 = peg$c12();

      if (s2) {
        s2 = undefined;
      } else {
        s2 = peg$FAILED;
      }

      if (s2 !== peg$FAILED) {
        s3 = peg$parsevalidTag();

        if (s3 !== peg$FAILED) {
          if (input.charCodeAt(peg$currPos) === 62) {
            s4 = peg$c13;
            peg$currPos++;
          } else {
            s4 = peg$FAILED;

            if (peg$silentFails === 0) {
              peg$fail(peg$c14);
            }
          }

          if (s4 !== peg$FAILED) {
            peg$savedPos = peg$currPos;
            s5 = peg$c15(s3);

            if (s5) {
              s5 = undefined;
            } else {
              s5 = peg$FAILED;
            }

            if (s5 !== peg$FAILED) {
              peg$savedPos = s0;
              s1 = peg$c16(s3);
              s0 = s1;
            } else {
              peg$currPos = s0;
              s0 = peg$FAILED;
            }
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parseclosingTag() {
    var s0, s1, s2, s3, s4, s5;
    s0 = peg$currPos;

    if (input.substr(peg$currPos, 2) === peg$c17) {
      s1 = peg$c17;
      peg$currPos += 2;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c18);
      }
    }

    if (s1 !== peg$FAILED) {
      peg$savedPos = peg$currPos;
      s2 = peg$c19();

      if (s2) {
        s2 = undefined;
      } else {
        s2 = peg$FAILED;
      }

      if (s2 !== peg$FAILED) {
        s3 = peg$parsevalidTag();

        if (s3 !== peg$FAILED) {
          if (input.charCodeAt(peg$currPos) === 62) {
            s4 = peg$c13;
            peg$currPos++;
          } else {
            s4 = peg$FAILED;

            if (peg$silentFails === 0) {
              peg$fail(peg$c14);
            }
          }

          if (s4 !== peg$FAILED) {
            peg$savedPos = peg$currPos;
            s5 = peg$c15(s3);

            if (s5) {
              s5 = undefined;
            } else {
              s5 = peg$FAILED;
            }

            if (s5 !== peg$FAILED) {
              peg$savedPos = s0;
              s1 = peg$c16(s3);
              s0 = s1;
            } else {
              peg$currPos = s0;
              s0 = peg$FAILED;
            }
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parseargumentElement() {
    var s0, s1, s2, s3, s4, s5;
    peg$silentFails++;
    s0 = peg$currPos;

    if (input.charCodeAt(peg$currPos) === 123) {
      s1 = peg$c21;
      peg$currPos++;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c22);
      }
    }

    if (s1 !== peg$FAILED) {
      s2 = peg$parse_();

      if (s2 !== peg$FAILED) {
        s3 = peg$parseargNameOrNumber();

        if (s3 !== peg$FAILED) {
          s4 = peg$parse_();

          if (s4 !== peg$FAILED) {
            if (input.charCodeAt(peg$currPos) === 125) {
              s5 = peg$c23;
              peg$currPos++;
            } else {
              s5 = peg$FAILED;

              if (peg$silentFails === 0) {
                peg$fail(peg$c24);
              }
            }

            if (s5 !== peg$FAILED) {
              peg$savedPos = s0;
              s1 = peg$c25(s3);
              s0 = s1;
            } else {
              peg$currPos = s0;
              s0 = peg$FAILED;
            }
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c20);
      }
    }

    return s0;
  }

  function peg$parsenumberSkeletonId() {
    var s0, s1, s2, s3, s4;
    peg$silentFails++;
    s0 = peg$currPos;
    s1 = [];
    s2 = peg$currPos;
    s3 = peg$currPos;
    peg$silentFails++;
    s4 = peg$parsewhiteSpace();

    if (s4 === peg$FAILED) {
      if (peg$c27.test(input.charAt(peg$currPos))) {
        s4 = input.charAt(peg$currPos);
        peg$currPos++;
      } else {
        s4 = peg$FAILED;

        if (peg$silentFails === 0) {
          peg$fail(peg$c28);
        }
      }
    }

    peg$silentFails--;

    if (s4 === peg$FAILED) {
      s3 = undefined;
    } else {
      peg$currPos = s3;
      s3 = peg$FAILED;
    }

    if (s3 !== peg$FAILED) {
      if (input.length > peg$currPos) {
        s4 = input.charAt(peg$currPos);
        peg$currPos++;
      } else {
        s4 = peg$FAILED;

        if (peg$silentFails === 0) {
          peg$fail(peg$c29);
        }
      }

      if (s4 !== peg$FAILED) {
        s3 = [s3, s4];
        s2 = s3;
      } else {
        peg$currPos = s2;
        s2 = peg$FAILED;
      }
    } else {
      peg$currPos = s2;
      s2 = peg$FAILED;
    }

    if (s2 !== peg$FAILED) {
      while (s2 !== peg$FAILED) {
        s1.push(s2);
        s2 = peg$currPos;
        s3 = peg$currPos;
        peg$silentFails++;
        s4 = peg$parsewhiteSpace();

        if (s4 === peg$FAILED) {
          if (peg$c27.test(input.charAt(peg$currPos))) {
            s4 = input.charAt(peg$currPos);
            peg$currPos++;
          } else {
            s4 = peg$FAILED;

            if (peg$silentFails === 0) {
              peg$fail(peg$c28);
            }
          }
        }

        peg$silentFails--;

        if (s4 === peg$FAILED) {
          s3 = undefined;
        } else {
          peg$currPos = s3;
          s3 = peg$FAILED;
        }

        if (s3 !== peg$FAILED) {
          if (input.length > peg$currPos) {
            s4 = input.charAt(peg$currPos);
            peg$currPos++;
          } else {
            s4 = peg$FAILED;

            if (peg$silentFails === 0) {
              peg$fail(peg$c29);
            }
          }

          if (s4 !== peg$FAILED) {
            s3 = [s3, s4];
            s2 = s3;
          } else {
            peg$currPos = s2;
            s2 = peg$FAILED;
          }
        } else {
          peg$currPos = s2;
          s2 = peg$FAILED;
        }
      }
    } else {
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      s0 = input.substring(s0, peg$currPos);
    } else {
      s0 = s1;
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c26);
      }
    }

    return s0;
  }

  function peg$parsenumberSkeletonTokenOption() {
    var s0, s1, s2;
    peg$silentFails++;
    s0 = peg$currPos;

    if (input.charCodeAt(peg$currPos) === 47) {
      s1 = peg$c31;
      peg$currPos++;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c32);
      }
    }

    if (s1 !== peg$FAILED) {
      s2 = peg$parsenumberSkeletonId();

      if (s2 !== peg$FAILED) {
        peg$savedPos = s0;
        s1 = peg$c33(s2);
        s0 = s1;
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c30);
      }
    }

    return s0;
  }

  function peg$parsenumberSkeletonToken() {
    var s0, s1, s2, s3, s4;
    peg$silentFails++;
    s0 = peg$currPos;
    s1 = peg$parse_();

    if (s1 !== peg$FAILED) {
      s2 = peg$parsenumberSkeletonId();

      if (s2 !== peg$FAILED) {
        s3 = [];
        s4 = peg$parsenumberSkeletonTokenOption();

        while (s4 !== peg$FAILED) {
          s3.push(s4);
          s4 = peg$parsenumberSkeletonTokenOption();
        }

        if (s3 !== peg$FAILED) {
          peg$savedPos = s0;
          s1 = peg$c35(s2, s3);
          s0 = s1;
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c34);
      }
    }

    return s0;
  }

  function peg$parsenumberSkeleton() {
    var s0, s1, s2;
    s0 = peg$currPos;
    s1 = [];
    s2 = peg$parsenumberSkeletonToken();

    if (s2 !== peg$FAILED) {
      while (s2 !== peg$FAILED) {
        s1.push(s2);
        s2 = peg$parsenumberSkeletonToken();
      }
    } else {
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      peg$savedPos = s0;
      s1 = peg$c36(s1);
    }

    s0 = s1;
    return s0;
  }

  function peg$parsenumberArgStyle() {
    var s0, s1, s2;
    s0 = peg$currPos;

    if (input.substr(peg$currPos, 2) === peg$c37) {
      s1 = peg$c37;
      peg$currPos += 2;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c38);
      }
    }

    if (s1 !== peg$FAILED) {
      s2 = peg$parsenumberSkeleton();

      if (s2 !== peg$FAILED) {
        peg$savedPos = s0;
        s1 = peg$c39(s2);
        s0 = s1;
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    if (s0 === peg$FAILED) {
      s0 = peg$currPos;
      peg$savedPos = peg$currPos;
      s1 = peg$c40();

      if (s1) {
        s1 = undefined;
      } else {
        s1 = peg$FAILED;
      }

      if (s1 !== peg$FAILED) {
        s2 = peg$parsemessageText();

        if (s2 !== peg$FAILED) {
          peg$savedPos = s0;
          s1 = peg$c41(s2);
          s0 = s1;
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    }

    return s0;
  }

  function peg$parsenumberFormatElement() {
    var s0, s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11, s12;
    s0 = peg$currPos;

    if (input.charCodeAt(peg$currPos) === 123) {
      s1 = peg$c21;
      peg$currPos++;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c22);
      }
    }

    if (s1 !== peg$FAILED) {
      s2 = peg$parse_();

      if (s2 !== peg$FAILED) {
        s3 = peg$parseargNameOrNumber();

        if (s3 !== peg$FAILED) {
          s4 = peg$parse_();

          if (s4 !== peg$FAILED) {
            if (input.charCodeAt(peg$currPos) === 44) {
              s5 = peg$c42;
              peg$currPos++;
            } else {
              s5 = peg$FAILED;

              if (peg$silentFails === 0) {
                peg$fail(peg$c43);
              }
            }

            if (s5 !== peg$FAILED) {
              s6 = peg$parse_();

              if (s6 !== peg$FAILED) {
                if (input.substr(peg$currPos, 6) === peg$c44) {
                  s7 = peg$c44;
                  peg$currPos += 6;
                } else {
                  s7 = peg$FAILED;

                  if (peg$silentFails === 0) {
                    peg$fail(peg$c45);
                  }
                }

                if (s7 !== peg$FAILED) {
                  s8 = peg$parse_();

                  if (s8 !== peg$FAILED) {
                    s9 = peg$currPos;

                    if (input.charCodeAt(peg$currPos) === 44) {
                      s10 = peg$c42;
                      peg$currPos++;
                    } else {
                      s10 = peg$FAILED;

                      if (peg$silentFails === 0) {
                        peg$fail(peg$c43);
                      }
                    }

                    if (s10 !== peg$FAILED) {
                      s11 = peg$parse_();

                      if (s11 !== peg$FAILED) {
                        s12 = peg$parsenumberArgStyle();

                        if (s12 !== peg$FAILED) {
                          s10 = [s10, s11, s12];
                          s9 = s10;
                        } else {
                          peg$currPos = s9;
                          s9 = peg$FAILED;
                        }
                      } else {
                        peg$currPos = s9;
                        s9 = peg$FAILED;
                      }
                    } else {
                      peg$currPos = s9;
                      s9 = peg$FAILED;
                    }

                    if (s9 === peg$FAILED) {
                      s9 = null;
                    }

                    if (s9 !== peg$FAILED) {
                      s10 = peg$parse_();

                      if (s10 !== peg$FAILED) {
                        if (input.charCodeAt(peg$currPos) === 125) {
                          s11 = peg$c23;
                          peg$currPos++;
                        } else {
                          s11 = peg$FAILED;

                          if (peg$silentFails === 0) {
                            peg$fail(peg$c24);
                          }
                        }

                        if (s11 !== peg$FAILED) {
                          peg$savedPos = s0;
                          s1 = peg$c46(s3, s7, s9);
                          s0 = s1;
                        } else {
                          peg$currPos = s0;
                          s0 = peg$FAILED;
                        }
                      } else {
                        peg$currPos = s0;
                        s0 = peg$FAILED;
                      }
                    } else {
                      peg$currPos = s0;
                      s0 = peg$FAILED;
                    }
                  } else {
                    peg$currPos = s0;
                    s0 = peg$FAILED;
                  }
                } else {
                  peg$currPos = s0;
                  s0 = peg$FAILED;
                }
              } else {
                peg$currPos = s0;
                s0 = peg$FAILED;
              }
            } else {
              peg$currPos = s0;
              s0 = peg$FAILED;
            }
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parsedateTimeSkeletonLiteral() {
    var s0, s1, s2, s3;
    s0 = peg$currPos;

    if (input.charCodeAt(peg$currPos) === 39) {
      s1 = peg$c47;
      peg$currPos++;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c48);
      }
    }

    if (s1 !== peg$FAILED) {
      s2 = [];
      s3 = peg$parsedoubleApostrophes();

      if (s3 === peg$FAILED) {
        if (peg$c49.test(input.charAt(peg$currPos))) {
          s3 = input.charAt(peg$currPos);
          peg$currPos++;
        } else {
          s3 = peg$FAILED;

          if (peg$silentFails === 0) {
            peg$fail(peg$c50);
          }
        }
      }

      if (s3 !== peg$FAILED) {
        while (s3 !== peg$FAILED) {
          s2.push(s3);
          s3 = peg$parsedoubleApostrophes();

          if (s3 === peg$FAILED) {
            if (peg$c49.test(input.charAt(peg$currPos))) {
              s3 = input.charAt(peg$currPos);
              peg$currPos++;
            } else {
              s3 = peg$FAILED;

              if (peg$silentFails === 0) {
                peg$fail(peg$c50);
              }
            }
          }
        }
      } else {
        s2 = peg$FAILED;
      }

      if (s2 !== peg$FAILED) {
        if (input.charCodeAt(peg$currPos) === 39) {
          s3 = peg$c47;
          peg$currPos++;
        } else {
          s3 = peg$FAILED;

          if (peg$silentFails === 0) {
            peg$fail(peg$c48);
          }
        }

        if (s3 !== peg$FAILED) {
          s1 = [s1, s2, s3];
          s0 = s1;
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    if (s0 === peg$FAILED) {
      s0 = [];
      s1 = peg$parsedoubleApostrophes();

      if (s1 === peg$FAILED) {
        if (peg$c51.test(input.charAt(peg$currPos))) {
          s1 = input.charAt(peg$currPos);
          peg$currPos++;
        } else {
          s1 = peg$FAILED;

          if (peg$silentFails === 0) {
            peg$fail(peg$c52);
          }
        }
      }

      if (s1 !== peg$FAILED) {
        while (s1 !== peg$FAILED) {
          s0.push(s1);
          s1 = peg$parsedoubleApostrophes();

          if (s1 === peg$FAILED) {
            if (peg$c51.test(input.charAt(peg$currPos))) {
              s1 = input.charAt(peg$currPos);
              peg$currPos++;
            } else {
              s1 = peg$FAILED;

              if (peg$silentFails === 0) {
                peg$fail(peg$c52);
              }
            }
          }
        }
      } else {
        s0 = peg$FAILED;
      }
    }

    return s0;
  }

  function peg$parsedateTimeSkeletonPattern() {
    var s0, s1;
    s0 = [];

    if (peg$c53.test(input.charAt(peg$currPos))) {
      s1 = input.charAt(peg$currPos);
      peg$currPos++;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c54);
      }
    }

    if (s1 !== peg$FAILED) {
      while (s1 !== peg$FAILED) {
        s0.push(s1);

        if (peg$c53.test(input.charAt(peg$currPos))) {
          s1 = input.charAt(peg$currPos);
          peg$currPos++;
        } else {
          s1 = peg$FAILED;

          if (peg$silentFails === 0) {
            peg$fail(peg$c54);
          }
        }
      }
    } else {
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parsedateTimeSkeleton() {
    var s0, s1, s2, s3;
    s0 = peg$currPos;
    s1 = peg$currPos;
    s2 = [];
    s3 = peg$parsedateTimeSkeletonLiteral();

    if (s3 === peg$FAILED) {
      s3 = peg$parsedateTimeSkeletonPattern();
    }

    if (s3 !== peg$FAILED) {
      while (s3 !== peg$FAILED) {
        s2.push(s3);
        s3 = peg$parsedateTimeSkeletonLiteral();

        if (s3 === peg$FAILED) {
          s3 = peg$parsedateTimeSkeletonPattern();
        }
      }
    } else {
      s2 = peg$FAILED;
    }

    if (s2 !== peg$FAILED) {
      s1 = input.substring(s1, peg$currPos);
    } else {
      s1 = s2;
    }

    if (s1 !== peg$FAILED) {
      peg$savedPos = s0;
      s1 = peg$c55(s1);
    }

    s0 = s1;
    return s0;
  }

  function peg$parsedateOrTimeArgStyle() {
    var s0, s1, s2;
    s0 = peg$currPos;

    if (input.substr(peg$currPos, 2) === peg$c37) {
      s1 = peg$c37;
      peg$currPos += 2;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c38);
      }
    }

    if (s1 !== peg$FAILED) {
      s2 = peg$parsedateTimeSkeleton();

      if (s2 !== peg$FAILED) {
        peg$savedPos = s0;
        s1 = peg$c39(s2);
        s0 = s1;
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    if (s0 === peg$FAILED) {
      s0 = peg$currPos;
      peg$savedPos = peg$currPos;
      s1 = peg$c56();

      if (s1) {
        s1 = undefined;
      } else {
        s1 = peg$FAILED;
      }

      if (s1 !== peg$FAILED) {
        s2 = peg$parsemessageText();

        if (s2 !== peg$FAILED) {
          peg$savedPos = s0;
          s1 = peg$c41(s2);
          s0 = s1;
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    }

    return s0;
  }

  function peg$parsedateOrTimeFormatElement() {
    var s0, s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11, s12;
    s0 = peg$currPos;

    if (input.charCodeAt(peg$currPos) === 123) {
      s1 = peg$c21;
      peg$currPos++;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c22);
      }
    }

    if (s1 !== peg$FAILED) {
      s2 = peg$parse_();

      if (s2 !== peg$FAILED) {
        s3 = peg$parseargNameOrNumber();

        if (s3 !== peg$FAILED) {
          s4 = peg$parse_();

          if (s4 !== peg$FAILED) {
            if (input.charCodeAt(peg$currPos) === 44) {
              s5 = peg$c42;
              peg$currPos++;
            } else {
              s5 = peg$FAILED;

              if (peg$silentFails === 0) {
                peg$fail(peg$c43);
              }
            }

            if (s5 !== peg$FAILED) {
              s6 = peg$parse_();

              if (s6 !== peg$FAILED) {
                if (input.substr(peg$currPos, 4) === peg$c57) {
                  s7 = peg$c57;
                  peg$currPos += 4;
                } else {
                  s7 = peg$FAILED;

                  if (peg$silentFails === 0) {
                    peg$fail(peg$c58);
                  }
                }

                if (s7 === peg$FAILED) {
                  if (input.substr(peg$currPos, 4) === peg$c59) {
                    s7 = peg$c59;
                    peg$currPos += 4;
                  } else {
                    s7 = peg$FAILED;

                    if (peg$silentFails === 0) {
                      peg$fail(peg$c60);
                    }
                  }
                }

                if (s7 !== peg$FAILED) {
                  s8 = peg$parse_();

                  if (s8 !== peg$FAILED) {
                    s9 = peg$currPos;

                    if (input.charCodeAt(peg$currPos) === 44) {
                      s10 = peg$c42;
                      peg$currPos++;
                    } else {
                      s10 = peg$FAILED;

                      if (peg$silentFails === 0) {
                        peg$fail(peg$c43);
                      }
                    }

                    if (s10 !== peg$FAILED) {
                      s11 = peg$parse_();

                      if (s11 !== peg$FAILED) {
                        s12 = peg$parsedateOrTimeArgStyle();

                        if (s12 !== peg$FAILED) {
                          s10 = [s10, s11, s12];
                          s9 = s10;
                        } else {
                          peg$currPos = s9;
                          s9 = peg$FAILED;
                        }
                      } else {
                        peg$currPos = s9;
                        s9 = peg$FAILED;
                      }
                    } else {
                      peg$currPos = s9;
                      s9 = peg$FAILED;
                    }

                    if (s9 === peg$FAILED) {
                      s9 = null;
                    }

                    if (s9 !== peg$FAILED) {
                      s10 = peg$parse_();

                      if (s10 !== peg$FAILED) {
                        if (input.charCodeAt(peg$currPos) === 125) {
                          s11 = peg$c23;
                          peg$currPos++;
                        } else {
                          s11 = peg$FAILED;

                          if (peg$silentFails === 0) {
                            peg$fail(peg$c24);
                          }
                        }

                        if (s11 !== peg$FAILED) {
                          peg$savedPos = s0;
                          s1 = peg$c46(s3, s7, s9);
                          s0 = s1;
                        } else {
                          peg$currPos = s0;
                          s0 = peg$FAILED;
                        }
                      } else {
                        peg$currPos = s0;
                        s0 = peg$FAILED;
                      }
                    } else {
                      peg$currPos = s0;
                      s0 = peg$FAILED;
                    }
                  } else {
                    peg$currPos = s0;
                    s0 = peg$FAILED;
                  }
                } else {
                  peg$currPos = s0;
                  s0 = peg$FAILED;
                }
              } else {
                peg$currPos = s0;
                s0 = peg$FAILED;
              }
            } else {
              peg$currPos = s0;
              s0 = peg$FAILED;
            }
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parsesimpleFormatElement() {
    var s0;
    s0 = peg$parsenumberFormatElement();

    if (s0 === peg$FAILED) {
      s0 = peg$parsedateOrTimeFormatElement();
    }

    return s0;
  }

  function peg$parsepluralElement() {
    var s0, s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11, s12, s13, s14, s15;
    s0 = peg$currPos;

    if (input.charCodeAt(peg$currPos) === 123) {
      s1 = peg$c21;
      peg$currPos++;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c22);
      }
    }

    if (s1 !== peg$FAILED) {
      s2 = peg$parse_();

      if (s2 !== peg$FAILED) {
        s3 = peg$parseargNameOrNumber();

        if (s3 !== peg$FAILED) {
          s4 = peg$parse_();

          if (s4 !== peg$FAILED) {
            if (input.charCodeAt(peg$currPos) === 44) {
              s5 = peg$c42;
              peg$currPos++;
            } else {
              s5 = peg$FAILED;

              if (peg$silentFails === 0) {
                peg$fail(peg$c43);
              }
            }

            if (s5 !== peg$FAILED) {
              s6 = peg$parse_();

              if (s6 !== peg$FAILED) {
                if (input.substr(peg$currPos, 6) === peg$c61) {
                  s7 = peg$c61;
                  peg$currPos += 6;
                } else {
                  s7 = peg$FAILED;

                  if (peg$silentFails === 0) {
                    peg$fail(peg$c62);
                  }
                }

                if (s7 === peg$FAILED) {
                  if (input.substr(peg$currPos, 13) === peg$c63) {
                    s7 = peg$c63;
                    peg$currPos += 13;
                  } else {
                    s7 = peg$FAILED;

                    if (peg$silentFails === 0) {
                      peg$fail(peg$c64);
                    }
                  }
                }

                if (s7 !== peg$FAILED) {
                  s8 = peg$parse_();

                  if (s8 !== peg$FAILED) {
                    if (input.charCodeAt(peg$currPos) === 44) {
                      s9 = peg$c42;
                      peg$currPos++;
                    } else {
                      s9 = peg$FAILED;

                      if (peg$silentFails === 0) {
                        peg$fail(peg$c43);
                      }
                    }

                    if (s9 !== peg$FAILED) {
                      s10 = peg$parse_();

                      if (s10 !== peg$FAILED) {
                        s11 = peg$currPos;

                        if (input.substr(peg$currPos, 7) === peg$c65) {
                          s12 = peg$c65;
                          peg$currPos += 7;
                        } else {
                          s12 = peg$FAILED;

                          if (peg$silentFails === 0) {
                            peg$fail(peg$c66);
                          }
                        }

                        if (s12 !== peg$FAILED) {
                          s13 = peg$parse_();

                          if (s13 !== peg$FAILED) {
                            s14 = peg$parsenumber();

                            if (s14 !== peg$FAILED) {
                              s12 = [s12, s13, s14];
                              s11 = s12;
                            } else {
                              peg$currPos = s11;
                              s11 = peg$FAILED;
                            }
                          } else {
                            peg$currPos = s11;
                            s11 = peg$FAILED;
                          }
                        } else {
                          peg$currPos = s11;
                          s11 = peg$FAILED;
                        }

                        if (s11 === peg$FAILED) {
                          s11 = null;
                        }

                        if (s11 !== peg$FAILED) {
                          s12 = peg$parse_();

                          if (s12 !== peg$FAILED) {
                            s13 = [];
                            s14 = peg$parsepluralOption();

                            if (s14 !== peg$FAILED) {
                              while (s14 !== peg$FAILED) {
                                s13.push(s14);
                                s14 = peg$parsepluralOption();
                              }
                            } else {
                              s13 = peg$FAILED;
                            }

                            if (s13 !== peg$FAILED) {
                              s14 = peg$parse_();

                              if (s14 !== peg$FAILED) {
                                if (input.charCodeAt(peg$currPos) === 125) {
                                  s15 = peg$c23;
                                  peg$currPos++;
                                } else {
                                  s15 = peg$FAILED;

                                  if (peg$silentFails === 0) {
                                    peg$fail(peg$c24);
                                  }
                                }

                                if (s15 !== peg$FAILED) {
                                  peg$savedPos = s0;
                                  s1 = peg$c67(s3, s7, s11, s13);
                                  s0 = s1;
                                } else {
                                  peg$currPos = s0;
                                  s0 = peg$FAILED;
                                }
                              } else {
                                peg$currPos = s0;
                                s0 = peg$FAILED;
                              }
                            } else {
                              peg$currPos = s0;
                              s0 = peg$FAILED;
                            }
                          } else {
                            peg$currPos = s0;
                            s0 = peg$FAILED;
                          }
                        } else {
                          peg$currPos = s0;
                          s0 = peg$FAILED;
                        }
                      } else {
                        peg$currPos = s0;
                        s0 = peg$FAILED;
                      }
                    } else {
                      peg$currPos = s0;
                      s0 = peg$FAILED;
                    }
                  } else {
                    peg$currPos = s0;
                    s0 = peg$FAILED;
                  }
                } else {
                  peg$currPos = s0;
                  s0 = peg$FAILED;
                }
              } else {
                peg$currPos = s0;
                s0 = peg$FAILED;
              }
            } else {
              peg$currPos = s0;
              s0 = peg$FAILED;
            }
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parseselectElement() {
    var s0, s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11, s12, s13;
    s0 = peg$currPos;

    if (input.charCodeAt(peg$currPos) === 123) {
      s1 = peg$c21;
      peg$currPos++;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c22);
      }
    }

    if (s1 !== peg$FAILED) {
      s2 = peg$parse_();

      if (s2 !== peg$FAILED) {
        s3 = peg$parseargNameOrNumber();

        if (s3 !== peg$FAILED) {
          s4 = peg$parse_();

          if (s4 !== peg$FAILED) {
            if (input.charCodeAt(peg$currPos) === 44) {
              s5 = peg$c42;
              peg$currPos++;
            } else {
              s5 = peg$FAILED;

              if (peg$silentFails === 0) {
                peg$fail(peg$c43);
              }
            }

            if (s5 !== peg$FAILED) {
              s6 = peg$parse_();

              if (s6 !== peg$FAILED) {
                if (input.substr(peg$currPos, 6) === peg$c68) {
                  s7 = peg$c68;
                  peg$currPos += 6;
                } else {
                  s7 = peg$FAILED;

                  if (peg$silentFails === 0) {
                    peg$fail(peg$c69);
                  }
                }

                if (s7 !== peg$FAILED) {
                  s8 = peg$parse_();

                  if (s8 !== peg$FAILED) {
                    if (input.charCodeAt(peg$currPos) === 44) {
                      s9 = peg$c42;
                      peg$currPos++;
                    } else {
                      s9 = peg$FAILED;

                      if (peg$silentFails === 0) {
                        peg$fail(peg$c43);
                      }
                    }

                    if (s9 !== peg$FAILED) {
                      s10 = peg$parse_();

                      if (s10 !== peg$FAILED) {
                        s11 = [];
                        s12 = peg$parseselectOption();

                        if (s12 !== peg$FAILED) {
                          while (s12 !== peg$FAILED) {
                            s11.push(s12);
                            s12 = peg$parseselectOption();
                          }
                        } else {
                          s11 = peg$FAILED;
                        }

                        if (s11 !== peg$FAILED) {
                          s12 = peg$parse_();

                          if (s12 !== peg$FAILED) {
                            if (input.charCodeAt(peg$currPos) === 125) {
                              s13 = peg$c23;
                              peg$currPos++;
                            } else {
                              s13 = peg$FAILED;

                              if (peg$silentFails === 0) {
                                peg$fail(peg$c24);
                              }
                            }

                            if (s13 !== peg$FAILED) {
                              peg$savedPos = s0;
                              s1 = peg$c70(s3, s11);
                              s0 = s1;
                            } else {
                              peg$currPos = s0;
                              s0 = peg$FAILED;
                            }
                          } else {
                            peg$currPos = s0;
                            s0 = peg$FAILED;
                          }
                        } else {
                          peg$currPos = s0;
                          s0 = peg$FAILED;
                        }
                      } else {
                        peg$currPos = s0;
                        s0 = peg$FAILED;
                      }
                    } else {
                      peg$currPos = s0;
                      s0 = peg$FAILED;
                    }
                  } else {
                    peg$currPos = s0;
                    s0 = peg$FAILED;
                  }
                } else {
                  peg$currPos = s0;
                  s0 = peg$FAILED;
                }
              } else {
                peg$currPos = s0;
                s0 = peg$FAILED;
              }
            } else {
              peg$currPos = s0;
              s0 = peg$FAILED;
            }
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parsepluralRuleSelectValue() {
    var s0, s1, s2, s3;
    s0 = peg$currPos;
    s1 = peg$currPos;

    if (input.charCodeAt(peg$currPos) === 61) {
      s2 = peg$c71;
      peg$currPos++;
    } else {
      s2 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c72);
      }
    }

    if (s2 !== peg$FAILED) {
      s3 = peg$parsenumber();

      if (s3 !== peg$FAILED) {
        s2 = [s2, s3];
        s1 = s2;
      } else {
        peg$currPos = s1;
        s1 = peg$FAILED;
      }
    } else {
      peg$currPos = s1;
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      s0 = input.substring(s0, peg$currPos);
    } else {
      s0 = s1;
    }

    if (s0 === peg$FAILED) {
      s0 = peg$parseargName();
    }

    return s0;
  }

  function peg$parseselectOption() {
    var s0, s1, s2, s3, s4, s5, s6, s7;
    s0 = peg$currPos;
    s1 = peg$parse_();

    if (s1 !== peg$FAILED) {
      s2 = peg$parseargName();

      if (s2 !== peg$FAILED) {
        s3 = peg$parse_();

        if (s3 !== peg$FAILED) {
          if (input.charCodeAt(peg$currPos) === 123) {
            s4 = peg$c21;
            peg$currPos++;
          } else {
            s4 = peg$FAILED;

            if (peg$silentFails === 0) {
              peg$fail(peg$c22);
            }
          }

          if (s4 !== peg$FAILED) {
            peg$savedPos = peg$currPos;
            s5 = peg$c73(s2);

            if (s5) {
              s5 = undefined;
            } else {
              s5 = peg$FAILED;
            }

            if (s5 !== peg$FAILED) {
              s6 = peg$parsemessage();

              if (s6 !== peg$FAILED) {
                if (input.charCodeAt(peg$currPos) === 125) {
                  s7 = peg$c23;
                  peg$currPos++;
                } else {
                  s7 = peg$FAILED;

                  if (peg$silentFails === 0) {
                    peg$fail(peg$c24);
                  }
                }

                if (s7 !== peg$FAILED) {
                  peg$savedPos = s0;
                  s1 = peg$c74(s2, s6);
                  s0 = s1;
                } else {
                  peg$currPos = s0;
                  s0 = peg$FAILED;
                }
              } else {
                peg$currPos = s0;
                s0 = peg$FAILED;
              }
            } else {
              peg$currPos = s0;
              s0 = peg$FAILED;
            }
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parsepluralOption() {
    var s0, s1, s2, s3, s4, s5, s6, s7;
    s0 = peg$currPos;
    s1 = peg$parse_();

    if (s1 !== peg$FAILED) {
      s2 = peg$parsepluralRuleSelectValue();

      if (s2 !== peg$FAILED) {
        s3 = peg$parse_();

        if (s3 !== peg$FAILED) {
          if (input.charCodeAt(peg$currPos) === 123) {
            s4 = peg$c21;
            peg$currPos++;
          } else {
            s4 = peg$FAILED;

            if (peg$silentFails === 0) {
              peg$fail(peg$c22);
            }
          }

          if (s4 !== peg$FAILED) {
            peg$savedPos = peg$currPos;
            s5 = peg$c75(s2);

            if (s5) {
              s5 = undefined;
            } else {
              s5 = peg$FAILED;
            }

            if (s5 !== peg$FAILED) {
              s6 = peg$parsemessage();

              if (s6 !== peg$FAILED) {
                if (input.charCodeAt(peg$currPos) === 125) {
                  s7 = peg$c23;
                  peg$currPos++;
                } else {
                  s7 = peg$FAILED;

                  if (peg$silentFails === 0) {
                    peg$fail(peg$c24);
                  }
                }

                if (s7 !== peg$FAILED) {
                  peg$savedPos = s0;
                  s1 = peg$c76(s2, s6);
                  s0 = s1;
                } else {
                  peg$currPos = s0;
                  s0 = peg$FAILED;
                }
              } else {
                peg$currPos = s0;
                s0 = peg$FAILED;
              }
            } else {
              peg$currPos = s0;
              s0 = peg$FAILED;
            }
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parsewhiteSpace() {
    var s0, s1;
    peg$silentFails++;

    if (peg$c78.test(input.charAt(peg$currPos))) {
      s0 = input.charAt(peg$currPos);
      peg$currPos++;
    } else {
      s0 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c79);
      }
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c77);
      }
    }

    return s0;
  }

  function peg$parsepatternSyntax() {
    var s0, s1;
    peg$silentFails++;

    if (peg$c81.test(input.charAt(peg$currPos))) {
      s0 = input.charAt(peg$currPos);
      peg$currPos++;
    } else {
      s0 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c82);
      }
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c80);
      }
    }

    return s0;
  }

  function peg$parse_() {
    var s0, s1, s2;
    peg$silentFails++;
    s0 = peg$currPos;
    s1 = [];
    s2 = peg$parsewhiteSpace();

    while (s2 !== peg$FAILED) {
      s1.push(s2);
      s2 = peg$parsewhiteSpace();
    }

    if (s1 !== peg$FAILED) {
      s0 = input.substring(s0, peg$currPos);
    } else {
      s0 = s1;
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c83);
      }
    }

    return s0;
  }

  function peg$parsenumber() {
    var s0, s1, s2;
    peg$silentFails++;
    s0 = peg$currPos;

    if (input.charCodeAt(peg$currPos) === 45) {
      s1 = peg$c85;
      peg$currPos++;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c86);
      }
    }

    if (s1 === peg$FAILED) {
      s1 = null;
    }

    if (s1 !== peg$FAILED) {
      s2 = peg$parseargNumber();

      if (s2 !== peg$FAILED) {
        peg$savedPos = s0;
        s1 = peg$c87(s1, s2);
        s0 = s1;
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c84);
      }
    }

    return s0;
  }

  function peg$parseapostrophe() {
    var s0, s1;
    peg$silentFails++;

    if (input.charCodeAt(peg$currPos) === 39) {
      s0 = peg$c47;
      peg$currPos++;
    } else {
      s0 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c48);
      }
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c88);
      }
    }

    return s0;
  }

  function peg$parsedoubleApostrophes() {
    var s0, s1;
    peg$silentFails++;
    s0 = peg$currPos;

    if (input.substr(peg$currPos, 2) === peg$c90) {
      s1 = peg$c90;
      peg$currPos += 2;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c91);
      }
    }

    if (s1 !== peg$FAILED) {
      peg$savedPos = s0;
      s1 = peg$c92();
    }

    s0 = s1;
    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c89);
      }
    }

    return s0;
  }

  function peg$parsequotedString() {
    var s0, s1, s2, s3, s4, s5;
    s0 = peg$currPos;

    if (input.charCodeAt(peg$currPos) === 39) {
      s1 = peg$c47;
      peg$currPos++;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c48);
      }
    }

    if (s1 !== peg$FAILED) {
      s2 = peg$parseescapedChar();

      if (s2 !== peg$FAILED) {
        s3 = peg$currPos;
        s4 = [];

        if (input.substr(peg$currPos, 2) === peg$c90) {
          s5 = peg$c90;
          peg$currPos += 2;
        } else {
          s5 = peg$FAILED;

          if (peg$silentFails === 0) {
            peg$fail(peg$c91);
          }
        }

        if (s5 === peg$FAILED) {
          if (peg$c49.test(input.charAt(peg$currPos))) {
            s5 = input.charAt(peg$currPos);
            peg$currPos++;
          } else {
            s5 = peg$FAILED;

            if (peg$silentFails === 0) {
              peg$fail(peg$c50);
            }
          }
        }

        while (s5 !== peg$FAILED) {
          s4.push(s5);

          if (input.substr(peg$currPos, 2) === peg$c90) {
            s5 = peg$c90;
            peg$currPos += 2;
          } else {
            s5 = peg$FAILED;

            if (peg$silentFails === 0) {
              peg$fail(peg$c91);
            }
          }

          if (s5 === peg$FAILED) {
            if (peg$c49.test(input.charAt(peg$currPos))) {
              s5 = input.charAt(peg$currPos);
              peg$currPos++;
            } else {
              s5 = peg$FAILED;

              if (peg$silentFails === 0) {
                peg$fail(peg$c50);
              }
            }
          }
        }

        if (s4 !== peg$FAILED) {
          s3 = input.substring(s3, peg$currPos);
        } else {
          s3 = s4;
        }

        if (s3 !== peg$FAILED) {
          if (input.charCodeAt(peg$currPos) === 39) {
            s4 = peg$c47;
            peg$currPos++;
          } else {
            s4 = peg$FAILED;

            if (peg$silentFails === 0) {
              peg$fail(peg$c48);
            }
          }

          if (s4 === peg$FAILED) {
            s4 = null;
          }

          if (s4 !== peg$FAILED) {
            peg$savedPos = s0;
            s1 = peg$c93(s2, s3);
            s0 = s1;
          } else {
            peg$currPos = s0;
            s0 = peg$FAILED;
          }
        } else {
          peg$currPos = s0;
          s0 = peg$FAILED;
        }
      } else {
        peg$currPos = s0;
        s0 = peg$FAILED;
      }
    } else {
      peg$currPos = s0;
      s0 = peg$FAILED;
    }

    return s0;
  }

  function peg$parseunquotedString() {
    var s0, s1, s2, s3;
    s0 = peg$currPos;
    s1 = peg$currPos;

    if (input.length > peg$currPos) {
      s2 = input.charAt(peg$currPos);
      peg$currPos++;
    } else {
      s2 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c29);
      }
    }

    if (s2 !== peg$FAILED) {
      peg$savedPos = peg$currPos;
      s3 = peg$c94(s2);

      if (s3) {
        s3 = undefined;
      } else {
        s3 = peg$FAILED;
      }

      if (s3 !== peg$FAILED) {
        s2 = [s2, s3];
        s1 = s2;
      } else {
        peg$currPos = s1;
        s1 = peg$FAILED;
      }
    } else {
      peg$currPos = s1;
      s1 = peg$FAILED;
    }

    if (s1 === peg$FAILED) {
      if (input.charCodeAt(peg$currPos) === 10) {
        s1 = peg$c95;
        peg$currPos++;
      } else {
        s1 = peg$FAILED;

        if (peg$silentFails === 0) {
          peg$fail(peg$c96);
        }
      }
    }

    if (s1 !== peg$FAILED) {
      s0 = input.substring(s0, peg$currPos);
    } else {
      s0 = s1;
    }

    return s0;
  }

  function peg$parseescapedChar() {
    var s0, s1, s2, s3;
    s0 = peg$currPos;
    s1 = peg$currPos;

    if (input.length > peg$currPos) {
      s2 = input.charAt(peg$currPos);
      peg$currPos++;
    } else {
      s2 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c29);
      }
    }

    if (s2 !== peg$FAILED) {
      peg$savedPos = peg$currPos;
      s3 = peg$c97(s2);

      if (s3) {
        s3 = undefined;
      } else {
        s3 = peg$FAILED;
      }

      if (s3 !== peg$FAILED) {
        s2 = [s2, s3];
        s1 = s2;
      } else {
        peg$currPos = s1;
        s1 = peg$FAILED;
      }
    } else {
      peg$currPos = s1;
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      s0 = input.substring(s0, peg$currPos);
    } else {
      s0 = s1;
    }

    return s0;
  }

  function peg$parseargNameOrNumber() {
    var s0, s1;
    peg$silentFails++;
    s0 = peg$currPos;
    s1 = peg$parseargNumber();

    if (s1 === peg$FAILED) {
      s1 = peg$parseargName();
    }

    if (s1 !== peg$FAILED) {
      s0 = input.substring(s0, peg$currPos);
    } else {
      s0 = s1;
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c98);
      }
    }

    return s0;
  }

  function peg$parsevalidTag() {
    var s0, s1;
    peg$silentFails++;
    s0 = peg$currPos;
    s1 = peg$parseargNumber();

    if (s1 === peg$FAILED) {
      s1 = peg$parsetagName();
    }

    if (s1 !== peg$FAILED) {
      s0 = input.substring(s0, peg$currPos);
    } else {
      s0 = s1;
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c99);
      }
    }

    return s0;
  }

  function peg$parseargNumber() {
    var s0, s1, s2, s3, s4;
    peg$silentFails++;
    s0 = peg$currPos;

    if (input.charCodeAt(peg$currPos) === 48) {
      s1 = peg$c101;
      peg$currPos++;
    } else {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c102);
      }
    }

    if (s1 !== peg$FAILED) {
      peg$savedPos = s0;
      s1 = peg$c103();
    }

    s0 = s1;

    if (s0 === peg$FAILED) {
      s0 = peg$currPos;
      s1 = peg$currPos;

      if (peg$c104.test(input.charAt(peg$currPos))) {
        s2 = input.charAt(peg$currPos);
        peg$currPos++;
      } else {
        s2 = peg$FAILED;

        if (peg$silentFails === 0) {
          peg$fail(peg$c105);
        }
      }

      if (s2 !== peg$FAILED) {
        s3 = [];

        if (peg$c106.test(input.charAt(peg$currPos))) {
          s4 = input.charAt(peg$currPos);
          peg$currPos++;
        } else {
          s4 = peg$FAILED;

          if (peg$silentFails === 0) {
            peg$fail(peg$c107);
          }
        }

        while (s4 !== peg$FAILED) {
          s3.push(s4);

          if (peg$c106.test(input.charAt(peg$currPos))) {
            s4 = input.charAt(peg$currPos);
            peg$currPos++;
          } else {
            s4 = peg$FAILED;

            if (peg$silentFails === 0) {
              peg$fail(peg$c107);
            }
          }
        }

        if (s3 !== peg$FAILED) {
          s2 = [s2, s3];
          s1 = s2;
        } else {
          peg$currPos = s1;
          s1 = peg$FAILED;
        }
      } else {
        peg$currPos = s1;
        s1 = peg$FAILED;
      }

      if (s1 !== peg$FAILED) {
        peg$savedPos = s0;
        s1 = peg$c108(s1);
      }

      s0 = s1;
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c100);
      }
    }

    return s0;
  }

  function peg$parseargName() {
    var s0, s1, s2, s3, s4;
    peg$silentFails++;
    s0 = peg$currPos;
    s1 = [];
    s2 = peg$currPos;
    s3 = peg$currPos;
    peg$silentFails++;
    s4 = peg$parsewhiteSpace();

    if (s4 === peg$FAILED) {
      s4 = peg$parsepatternSyntax();
    }

    peg$silentFails--;

    if (s4 === peg$FAILED) {
      s3 = undefined;
    } else {
      peg$currPos = s3;
      s3 = peg$FAILED;
    }

    if (s3 !== peg$FAILED) {
      if (input.length > peg$currPos) {
        s4 = input.charAt(peg$currPos);
        peg$currPos++;
      } else {
        s4 = peg$FAILED;

        if (peg$silentFails === 0) {
          peg$fail(peg$c29);
        }
      }

      if (s4 !== peg$FAILED) {
        s3 = [s3, s4];
        s2 = s3;
      } else {
        peg$currPos = s2;
        s2 = peg$FAILED;
      }
    } else {
      peg$currPos = s2;
      s2 = peg$FAILED;
    }

    if (s2 !== peg$FAILED) {
      while (s2 !== peg$FAILED) {
        s1.push(s2);
        s2 = peg$currPos;
        s3 = peg$currPos;
        peg$silentFails++;
        s4 = peg$parsewhiteSpace();

        if (s4 === peg$FAILED) {
          s4 = peg$parsepatternSyntax();
        }

        peg$silentFails--;

        if (s4 === peg$FAILED) {
          s3 = undefined;
        } else {
          peg$currPos = s3;
          s3 = peg$FAILED;
        }

        if (s3 !== peg$FAILED) {
          if (input.length > peg$currPos) {
            s4 = input.charAt(peg$currPos);
            peg$currPos++;
          } else {
            s4 = peg$FAILED;

            if (peg$silentFails === 0) {
              peg$fail(peg$c29);
            }
          }

          if (s4 !== peg$FAILED) {
            s3 = [s3, s4];
            s2 = s3;
          } else {
            peg$currPos = s2;
            s2 = peg$FAILED;
          }
        } else {
          peg$currPos = s2;
          s2 = peg$FAILED;
        }
      }
    } else {
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      s0 = input.substring(s0, peg$currPos);
    } else {
      s0 = s1;
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c109);
      }
    }

    return s0;
  }

  function peg$parsetagName() {
    var s0, s1, s2, s3, s4;
    peg$silentFails++;
    s0 = peg$currPos;
    s1 = [];

    if (input.charCodeAt(peg$currPos) === 45) {
      s2 = peg$c85;
      peg$currPos++;
    } else {
      s2 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c86);
      }
    }

    if (s2 === peg$FAILED) {
      s2 = peg$currPos;
      s3 = peg$currPos;
      peg$silentFails++;
      s4 = peg$parsewhiteSpace();

      if (s4 === peg$FAILED) {
        s4 = peg$parsepatternSyntax();
      }

      peg$silentFails--;

      if (s4 === peg$FAILED) {
        s3 = undefined;
      } else {
        peg$currPos = s3;
        s3 = peg$FAILED;
      }

      if (s3 !== peg$FAILED) {
        if (input.length > peg$currPos) {
          s4 = input.charAt(peg$currPos);
          peg$currPos++;
        } else {
          s4 = peg$FAILED;

          if (peg$silentFails === 0) {
            peg$fail(peg$c29);
          }
        }

        if (s4 !== peg$FAILED) {
          s3 = [s3, s4];
          s2 = s3;
        } else {
          peg$currPos = s2;
          s2 = peg$FAILED;
        }
      } else {
        peg$currPos = s2;
        s2 = peg$FAILED;
      }
    }

    if (s2 !== peg$FAILED) {
      while (s2 !== peg$FAILED) {
        s1.push(s2);

        if (input.charCodeAt(peg$currPos) === 45) {
          s2 = peg$c85;
          peg$currPos++;
        } else {
          s2 = peg$FAILED;

          if (peg$silentFails === 0) {
            peg$fail(peg$c86);
          }
        }

        if (s2 === peg$FAILED) {
          s2 = peg$currPos;
          s3 = peg$currPos;
          peg$silentFails++;
          s4 = peg$parsewhiteSpace();

          if (s4 === peg$FAILED) {
            s4 = peg$parsepatternSyntax();
          }

          peg$silentFails--;

          if (s4 === peg$FAILED) {
            s3 = undefined;
          } else {
            peg$currPos = s3;
            s3 = peg$FAILED;
          }

          if (s3 !== peg$FAILED) {
            if (input.length > peg$currPos) {
              s4 = input.charAt(peg$currPos);
              peg$currPos++;
            } else {
              s4 = peg$FAILED;

              if (peg$silentFails === 0) {
                peg$fail(peg$c29);
              }
            }

            if (s4 !== peg$FAILED) {
              s3 = [s3, s4];
              s2 = s3;
            } else {
              peg$currPos = s2;
              s2 = peg$FAILED;
            }
          } else {
            peg$currPos = s2;
            s2 = peg$FAILED;
          }
        }
      }
    } else {
      s1 = peg$FAILED;
    }

    if (s1 !== peg$FAILED) {
      s0 = input.substring(s0, peg$currPos);
    } else {
      s0 = s1;
    }

    peg$silentFails--;

    if (s0 === peg$FAILED) {
      s1 = peg$FAILED;

      if (peg$silentFails === 0) {
        peg$fail(peg$c110);
      }
    }

    return s0;
  }

  var messageCtx = ['root'];

  function isNestedMessageText() {
    return messageCtx.length > 1;
  }

  function isInPluralOption() {
    return messageCtx[messageCtx.length - 1] === 'plural';
  }

  function insertLocation() {
    return options && options.captureLocation ? {
      location: location()
    } : {};
  }

  function ignoreTag() {
    return options && options.ignoreTag;
  }

  peg$result = peg$startRuleFunction();

  if (peg$result !== peg$FAILED && peg$currPos === input.length) {
    return peg$result;
  } else {
    if (peg$result !== peg$FAILED && peg$currPos < input.length) {
      peg$fail(peg$endExpectation());
    }

    throw peg$buildStructuredError(peg$maxFailExpected, peg$maxFailPos < input.length ? input.charAt(peg$maxFailPos) : null, peg$maxFailPos < input.length ? peg$computeLocation(peg$maxFailPos, peg$maxFailPos + 1) : peg$computeLocation(peg$maxFailPos, peg$maxFailPos));
  }
}

var pegParse = peg$parse;
// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/instance/splice.js
var splice = __webpack_require__("gQl7");
var splice_default = /*#__PURE__*/__webpack_require__.n(splice);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/object/keys.js
var keys = __webpack_require__("cUqe");
var keys_default = /*#__PURE__*/__webpack_require__.n(keys);

// EXTERNAL MODULE: ../labels/node_modules/@babel/runtime-corejs3/core-js/instance/for-each.js
var for_each = __webpack_require__("jW5y");
var for_each_default = /*#__PURE__*/__webpack_require__.n(for_each);

// CONCATENATED MODULE: ../labels/node_modules/intl-messageformat-parser/lib/normalize.js






var __spreadArrays = undefined && undefined.__spreadArrays || function () {
  for (var s = 0, i = 0, il = arguments.length; i < il; i++) {
    s += arguments[i].length;
  }

  for (var r = Array(s), k = 0, i = 0; i < il; i++) {
    for (var a = arguments[i], j = 0, jl = a.length; j < jl; j++, k++) {
      r[k] = a[j];
    }
  }

  return r;
};



var PLURAL_HASHTAG_REGEX = /(^|[^\\])#/g;
/**
 * Whether to convert `#` in plural rule options
 * to `{var, number}`
 * @param el AST Element
 * @param pluralStack current plural stack
 */

function normalizeHashtagInPlural(els) {
  for_each_default()(els).call(els, function (el) {
    var _context;

    // If we're encountering a plural el
    if (!Object(types["k" /* isPluralElement */])(el) && !Object(types["m" /* isSelectElement */])(el)) {
      return;
    } // Go down the options and search for # in any literal element


    for_each_default()(_context = keys_default()(el.options)).call(_context, function (id) {
      var _a;

      var opt = el.options[id]; // If we got a match, we have to split this
      // and inject a NumberElement in the middle

      var matchingLiteralElIndex = -1;
      var literalEl = undefined;

      for (var i = 0; i < opt.value.length; i++) {
        var el_1 = opt.value[i];

        if (Object(types["h" /* isLiteralElement */])(el_1) && PLURAL_HASHTAG_REGEX.test(el_1.value)) {
          matchingLiteralElIndex = i;
          literalEl = el_1;
          break;
        }
      }

      if (literalEl) {
        var newValue = literalEl.value.replace(PLURAL_HASHTAG_REGEX, "$1{" + el.value + ", number}");
        var newEls = pegParse(newValue);

        splice_default()(_a = opt.value).apply(_a, __spreadArrays([matchingLiteralElIndex, 1], newEls));
      }

      normalizeHashtagInPlural(opt.value);
    });
  });
}
// EXTERNAL MODULE: ../labels/node_modules/intl-messageformat-parser/lib/skeleton.js
var skeleton = __webpack_require__("S42S");

// CONCATENATED MODULE: ../labels/node_modules/intl-messageformat-parser/lib/index.js





function parse(input, opts) {
  var els = pegParse(input, opts);

  if (!opts || opts.normalizeHashtagInPlural !== false) {
    normalizeHashtagInPlural(els);
  }

  return els;
}

/***/ }),

/***/ "ft9U":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("YH+Y");

module.exports = parent;


/***/ }),

/***/ "g6a+":
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__("ct80");
var classof = __webpack_require__("amH4");

var split = ''.split;

// fallback for non-array-like ES3 and non-enumerable old V8 strings
module.exports = fails(function () {
  // throws an error in rhino, see https://github.com/mozilla/rhino/issues/346
  // eslint-disable-next-line no-prototype-builtins
  return !Object('z').propertyIsEnumerable(0);
}) ? function (it) {
  return classof(it) == 'String' ? split.call(it, '') : Object(it);
} : Object;


/***/ }),

/***/ "gQl7":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("B4Ad");

/***/ }),

/***/ "guiJ":
/***/ (function(module, exports, __webpack_require__) {

var anObject = __webpack_require__("FXyv");
var defineProperties = __webpack_require__("uZvN");
var enumBugKeys = __webpack_require__("sX5C");
var hiddenKeys = __webpack_require__("1odi");
var html = __webpack_require__("kySU");
var documentCreateElement = __webpack_require__("8r/q");
var sharedKey = __webpack_require__("MyxS");

var GT = '>';
var LT = '<';
var PROTOTYPE = 'prototype';
var SCRIPT = 'script';
var IE_PROTO = sharedKey('IE_PROTO');

var EmptyConstructor = function () { /* empty */ };

var scriptTag = function (content) {
  return LT + SCRIPT + GT + content + LT + '/' + SCRIPT + GT;
};

// Create object with fake `null` prototype: use ActiveX Object with cleared prototype
var NullProtoObjectViaActiveX = function (activeXDocument) {
  activeXDocument.write(scriptTag(''));
  activeXDocument.close();
  var temp = activeXDocument.parentWindow.Object;
  activeXDocument = null; // avoid memory leak
  return temp;
};

// Create object with fake `null` prototype: use iframe Object with cleared prototype
var NullProtoObjectViaIFrame = function () {
  // Thrash, waste and sodomy: IE GC bug
  var iframe = documentCreateElement('iframe');
  var JS = 'java' + SCRIPT + ':';
  var iframeDocument;
  iframe.style.display = 'none';
  html.appendChild(iframe);
  // https://github.com/zloirock/core-js/issues/475
  iframe.src = String(JS);
  iframeDocument = iframe.contentWindow.document;
  iframeDocument.open();
  iframeDocument.write(scriptTag('document.F=Object'));
  iframeDocument.close();
  return iframeDocument.F;
};

// Check for document.domain and active x support
// No need to use active x approach when document.domain is not set
// see https://github.com/es-shims/es5-shim/issues/150
// variation of https://github.com/kitcambridge/es5-shim/commit/4f738ac066346
// avoid IE GC bug
var activeXDocument;
var NullProtoObject = function () {
  try {
    /* global ActiveXObject */
    activeXDocument = document.domain && new ActiveXObject('htmlfile');
  } catch (error) { /* ignore */ }
  NullProtoObject = activeXDocument ? NullProtoObjectViaActiveX(activeXDocument) : NullProtoObjectViaIFrame();
  var length = enumBugKeys.length;
  while (length--) delete NullProtoObject[PROTOTYPE][enumBugKeys[length]];
  return NullProtoObject();
};

hiddenKeys[IE_PROTO] = true;

// `Object.create` method
// https://tc39.github.io/ecma262/#sec-object.create
module.exports = Object.create || function create(O, Properties) {
  var result;
  if (O !== null) {
    EmptyConstructor[PROTOTYPE] = anObject(O);
    result = new EmptyConstructor();
    EmptyConstructor[PROTOTYPE] = null;
    // add "__proto__" for Object.getPrototypeOf polyfill
    result[IE_PROTO] = O;
  } else result = NullProtoObject();
  return Properties === undefined ? result : defineProperties(result, Properties);
};


/***/ }),

/***/ "ho0z":
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__("1Mu/");
var defineProperty = __webpack_require__("q9+l").f;

var FunctionPrototype = Function.prototype;
var FunctionPrototypeToString = FunctionPrototype.toString;
var nameRE = /^\s*function ([^ (]*)/;
var NAME = 'name';

// Function instances `.name` property
// https://tc39.github.io/ecma262/#sec-function-instances-name
if (DESCRIPTORS && !(NAME in FunctionPrototype)) {
  defineProperty(FunctionPrototype, NAME, {
    configurable: true,
    get: function () {
      try {
        return FunctionPrototypeToString.call(this).match(nameRE)[1];
      } catch (error) {
        return '';
      }
    }
  });
}


/***/ }),

/***/ "hpdy":
/***/ (function(module, exports) {

module.exports = function (it) {
  if (typeof it != 'function') {
    throw TypeError(String(it) + ' is not a function');
  } return it;
};


/***/ }),

/***/ "i6Tr":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("wkL6");

/***/ }),

/***/ "i7Kn":
/***/ (function(module, exports) {

var ceil = Math.ceil;
var floor = Math.floor;

// `ToInteger` abstract operation
// https://tc39.github.io/ecma262/#sec-tointeger
module.exports = function (argument) {
  return isNaN(argument = +argument) ? 0 : (argument > 0 ? floor : ceil)(argument);
};


/***/ }),

/***/ "iDMO":
/***/ (function(module, exports, __webpack_require__) {

var shared = __webpack_require__("PLru");
var uid = __webpack_require__("apkA");

var keys = shared('keys');

module.exports = function (key) {
  return keys[key] || (keys[key] = uid(key));
};


/***/ }),

/***/ "iKE+":
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__("1Mu/");
var global = __webpack_require__("9JhN");
var isForced = __webpack_require__("66wQ");
var inheritIfRequired = __webpack_require__("j6nH");
var defineProperty = __webpack_require__("q9+l").f;
var getOwnPropertyNames = __webpack_require__("ZdBB").f;
var isRegExp = __webpack_require__("jl0/");
var getFlags = __webpack_require__("q/0V");
var stickyHelpers = __webpack_require__("L2rT");
var redefine = __webpack_require__("uLp7");
var fails = __webpack_require__("ct80");
var setInternalState = __webpack_require__("zc29").set;
var setSpecies = __webpack_require__("Ch6y");
var wellKnownSymbol = __webpack_require__("fVMg");

var MATCH = wellKnownSymbol('match');
var NativeRegExp = global.RegExp;
var RegExpPrototype = NativeRegExp.prototype;
var re1 = /a/g;
var re2 = /a/g;

// "new" should create a new object, old webkit bug
var CORRECT_NEW = new NativeRegExp(re1) !== re1;

var UNSUPPORTED_Y = stickyHelpers.UNSUPPORTED_Y;

var FORCED = DESCRIPTORS && isForced('RegExp', (!CORRECT_NEW || UNSUPPORTED_Y || fails(function () {
  re2[MATCH] = false;
  // RegExp constructor can alter flags and IsRegExp works correct with @@match
  return NativeRegExp(re1) != re1 || NativeRegExp(re2) == re2 || NativeRegExp(re1, 'i') != '/a/i';
})));

// `RegExp` constructor
// https://tc39.github.io/ecma262/#sec-regexp-constructor
if (FORCED) {
  var RegExpWrapper = function RegExp(pattern, flags) {
    var thisIsRegExp = this instanceof RegExpWrapper;
    var patternIsRegExp = isRegExp(pattern);
    var flagsAreUndefined = flags === undefined;
    var sticky;

    if (!thisIsRegExp && patternIsRegExp && pattern.constructor === RegExpWrapper && flagsAreUndefined) {
      return pattern;
    }

    if (CORRECT_NEW) {
      if (patternIsRegExp && !flagsAreUndefined) pattern = pattern.source;
    } else if (pattern instanceof RegExpWrapper) {
      if (flagsAreUndefined) flags = getFlags.call(pattern);
      pattern = pattern.source;
    }

    if (UNSUPPORTED_Y) {
      sticky = !!flags && flags.indexOf('y') > -1;
      if (sticky) flags = flags.replace(/y/g, '');
    }

    var result = inheritIfRequired(
      CORRECT_NEW ? new NativeRegExp(pattern, flags) : NativeRegExp(pattern, flags),
      thisIsRegExp ? this : RegExpPrototype,
      RegExpWrapper
    );

    if (UNSUPPORTED_Y && sticky) setInternalState(result, { sticky: sticky });

    return result;
  };
  var proxy = function (key) {
    key in RegExpWrapper || defineProperty(RegExpWrapper, key, {
      configurable: true,
      get: function () { return NativeRegExp[key]; },
      set: function (it) { NativeRegExp[key] = it; }
    });
  };
  var keys = getOwnPropertyNames(NativeRegExp);
  var index = 0;
  while (keys.length > index) proxy(keys[index++]);
  RegExpPrototype.constructor = RegExpWrapper;
  RegExpWrapper.prototype = RegExpPrototype;
  redefine(global, 'RegExp', RegExpWrapper);
}

// https://tc39.github.io/ecma262/#sec-get-regexp-@@species
setSpecies('RegExp');


/***/ }),

/***/ "iYt3":
/***/ (function(module, exports) {

exports.f = Object.getOwnPropertySymbols;


/***/ }),

/***/ "iaIM":
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__("n9AK");
var getBuiltIn = __webpack_require__("wF8L");
var fails = __webpack_require__("XU0c");

var $stringify = getBuiltIn('JSON', 'stringify');
var re = /[\uD800-\uDFFF]/g;
var low = /^[\uD800-\uDBFF]$/;
var hi = /^[\uDC00-\uDFFF]$/;

var fix = function (match, offset, string) {
  var prev = string.charAt(offset - 1);
  var next = string.charAt(offset + 1);
  if ((low.test(match) && !hi.test(next)) || (hi.test(match) && !low.test(prev))) {
    return '\\u' + match.charCodeAt(0).toString(16);
  } return match;
};

var FORCED = fails(function () {
  return $stringify('\uDF06\uD834') !== '"\\udf06\\ud834"'
    || $stringify('\uDEAD') !== '"\\udead"';
});

if ($stringify) {
  // https://github.com/tc39/proposal-well-formed-stringify
  $({ target: 'JSON', stat: true, forced: FORCED }, {
    // eslint-disable-next-line no-unused-vars
    stringify: function stringify(it, replacer, space) {
      var result = $stringify.apply(null, arguments);
      return typeof result == 'string' ? result.replace(re, fix) : result;
    }
  });
}


/***/ }),

/***/ "j0PW":
/***/ (function(module, exports) {

module.exports = {};


/***/ }),

/***/ "j0cD":
/***/ (function(module, exports) {

// `RequireObjectCoercible` abstract operation
// https://tc39.github.io/ecma262/#sec-requireobjectcoercible
module.exports = function (it) {
  if (it == undefined) throw TypeError("Can't call method on " + it);
  return it;
};


/***/ }),

/***/ "j6nH":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("dSaG");
var setPrototypeOf = __webpack_require__("waID");

// makes subclassing work correct for wrapped built-ins
module.exports = function ($this, dummy, Wrapper) {
  var NewTarget, NewTargetPrototype;
  if (
    // it can work only with native `setPrototypeOf`
    setPrototypeOf &&
    // we haven't completely correct pre-ES6 way for getting `new.target`, so use this
    typeof (NewTarget = dummy.constructor) == 'function' &&
    NewTarget !== Wrapper &&
    isObject(NewTargetPrototype = NewTarget.prototype) &&
    NewTargetPrototype !== Wrapper.prototype
  ) setPrototypeOf($this, NewTargetPrototype);
  return $this;
};


/***/ }),

/***/ "jNzf":
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__("5Jdw");
var definePropertyModule = __webpack_require__("JliG");
var createPropertyDescriptor = __webpack_require__("96pp");

module.exports = DESCRIPTORS ? function (object, key, value) {
  return definePropertyModule.f(object, key, createPropertyDescriptor(1, value));
} : function (object, key, value) {
  object[key] = value;
  return object;
};


/***/ }),

/***/ "jQ/y":
/***/ (function(module, exports, __webpack_require__) {

"use strict";
// `Symbol.prototype.description` getter
// https://tc39.github.io/ecma262/#sec-symbol.prototype.description

var $ = __webpack_require__("ax0f");
var DESCRIPTORS = __webpack_require__("1Mu/");
var global = __webpack_require__("9JhN");
var has = __webpack_require__("8aeu");
var isObject = __webpack_require__("dSaG");
var defineProperty = __webpack_require__("q9+l").f;
var copyConstructorProperties = __webpack_require__("tjTa");

var NativeSymbol = global.Symbol;

if (DESCRIPTORS && typeof NativeSymbol == 'function' && (!('description' in NativeSymbol.prototype) ||
  // Safari 12 bug
  NativeSymbol().description !== undefined
)) {
  var EmptyStringDescriptionStore = {};
  // wrap Symbol constructor for correct work with undefined description
  var SymbolWrapper = function Symbol() {
    var description = arguments.length < 1 || arguments[0] === undefined ? undefined : String(arguments[0]);
    var result = this instanceof SymbolWrapper
      ? new NativeSymbol(description)
      // in Edge 13, String(Symbol(undefined)) === 'Symbol(undefined)'
      : description === undefined ? NativeSymbol() : NativeSymbol(description);
    if (description === '') EmptyStringDescriptionStore[result] = true;
    return result;
  };
  copyConstructorProperties(SymbolWrapper, NativeSymbol);
  var symbolPrototype = SymbolWrapper.prototype = NativeSymbol.prototype;
  symbolPrototype.constructor = SymbolWrapper;

  var symbolToString = symbolPrototype.toString;
  var native = String(NativeSymbol('test')) == 'Symbol(test)';
  var regexp = /^Symbol\((.*)\)[^)]+$/;
  defineProperty(symbolPrototype, 'description', {
    configurable: true,
    get: function description() {
      var symbol = isObject(this) ? this.valueOf() : this;
      var string = symbolToString.call(symbol);
      if (has(EmptyStringDescriptionStore, symbol)) return '';
      var desc = native ? string.slice(7, -1) : string.replace(regexp, '$1');
      return desc === '' ? undefined : desc;
    }
  });

  $({ global: true, forced: true }, {
    Symbol: SymbolWrapper
  });
}


/***/ }),

/***/ "jW5y":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("wkL6");

/***/ }),

/***/ "jelS":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.toStringTag` well-known symbol
// https://tc39.github.io/ecma262/#sec-symbol.tostringtag
defineWellKnownSymbol('toStringTag');


/***/ }),

/***/ "jl0/":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("dSaG");
var classof = __webpack_require__("amH4");
var wellKnownSymbol = __webpack_require__("fVMg");

var MATCH = wellKnownSymbol('match');

// `IsRegExp` abstract operation
// https://tc39.github.io/ecma262/#sec-isregexp
module.exports = function (it) {
  var isRegExp;
  return isObject(it) && ((isRegExp = it[MATCH]) !== undefined ? !!isRegExp : classof(it) == 'RegExp');
};


/***/ }),

/***/ "jwue":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("ax0f");
var forEach = __webpack_require__("6OVi");

// `Array.prototype.forEach` method
// https://tc39.github.io/ecma262/#sec-array.prototype.foreach
$({ target: 'Array', proto: true, forced: [].forEach != forEach }, {
  forEach: forEach
});


/***/ }),

/***/ "kD1X":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("lpqW");

module.exports = parent;


/***/ }),

/***/ "kDpG":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("9hnf");
var entryVirtual = __webpack_require__("Gfq3");

module.exports = entryVirtual('Array').forEach;


/***/ }),

/***/ "kEgS":
/***/ (function(module, exports) {

module.exports = function (src, callback) {
  if (typeof src == 'string') {
    var script = document.createElement('script');

    if (script.readyState) {
      // IE
      script.onreadystatechange = function () {
        if (script.readyState == "loaded" || script.readyState == "complete") {
          script.onreadystatechange = null;
          if (typeof callback == "function") callback();
          callback = null;
        }
      };
    } else {
      script.onload = function () {
        if (typeof callback == "function") callback();
        callback = null;
      };
    }

    script.charset = "utf-8";
    script.src = src;
    script.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(script);
  } else {
    var loadedScriptCount = 0;

    for (var i = 0; i < src.length; i++) {
      loadJs(src[i], function () {
        loadedScriptCount++;

        if (loadedScriptCount == src.length) {
          callback();
          callback = null;
        }
      });
    }
  }
};

/***/ }),

/***/ "kXRz":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("8bDY");
var keys = __webpack_require__("vFRI");
var classof = __webpack_require__("r/P8");
var ArrayPrototype = Array.prototype;

var DOMIterables = {
  DOMTokenList: true,
  NodeList: true
};

module.exports = function (it) {
  var own = it.keys;
  return it === ArrayPrototype || (it instanceof Array && own === ArrayPrototype.keys)
    // eslint-disable-next-line no-prototype-builtins
    || DOMIterables.hasOwnProperty(classof(it)) ? keys : own;
};


/***/ }),

/***/ "kYm/":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("n9AK");
var createIteratorConstructor = __webpack_require__("DTge");
var getPrototypeOf = __webpack_require__("K1oV");
var setPrototypeOf = __webpack_require__("wXON");
var setToStringTag = __webpack_require__("CtlU");
var createNonEnumerableProperty = __webpack_require__("jNzf");
var redefine = __webpack_require__("yX36");
var wellKnownSymbol = __webpack_require__("HVcX");
var IS_PURE = __webpack_require__("Vl7J");
var Iterators = __webpack_require__("m/wn");
var IteratorsCore = __webpack_require__("/L0j");

var IteratorPrototype = IteratorsCore.IteratorPrototype;
var BUGGY_SAFARI_ITERATORS = IteratorsCore.BUGGY_SAFARI_ITERATORS;
var ITERATOR = wellKnownSymbol('iterator');
var KEYS = 'keys';
var VALUES = 'values';
var ENTRIES = 'entries';

var returnThis = function () { return this; };

module.exports = function (Iterable, NAME, IteratorConstructor, next, DEFAULT, IS_SET, FORCED) {
  createIteratorConstructor(IteratorConstructor, NAME, next);

  var getIterationMethod = function (KIND) {
    if (KIND === DEFAULT && defaultIterator) return defaultIterator;
    if (!BUGGY_SAFARI_ITERATORS && KIND in IterablePrototype) return IterablePrototype[KIND];
    switch (KIND) {
      case KEYS: return function keys() { return new IteratorConstructor(this, KIND); };
      case VALUES: return function values() { return new IteratorConstructor(this, KIND); };
      case ENTRIES: return function entries() { return new IteratorConstructor(this, KIND); };
    } return function () { return new IteratorConstructor(this); };
  };

  var TO_STRING_TAG = NAME + ' Iterator';
  var INCORRECT_VALUES_NAME = false;
  var IterablePrototype = Iterable.prototype;
  var nativeIterator = IterablePrototype[ITERATOR]
    || IterablePrototype['@@iterator']
    || DEFAULT && IterablePrototype[DEFAULT];
  var defaultIterator = !BUGGY_SAFARI_ITERATORS && nativeIterator || getIterationMethod(DEFAULT);
  var anyNativeIterator = NAME == 'Array' ? IterablePrototype.entries || nativeIterator : nativeIterator;
  var CurrentIteratorPrototype, methods, KEY;

  // fix native
  if (anyNativeIterator) {
    CurrentIteratorPrototype = getPrototypeOf(anyNativeIterator.call(new Iterable()));
    if (IteratorPrototype !== Object.prototype && CurrentIteratorPrototype.next) {
      if (!IS_PURE && getPrototypeOf(CurrentIteratorPrototype) !== IteratorPrototype) {
        if (setPrototypeOf) {
          setPrototypeOf(CurrentIteratorPrototype, IteratorPrototype);
        } else if (typeof CurrentIteratorPrototype[ITERATOR] != 'function') {
          createNonEnumerableProperty(CurrentIteratorPrototype, ITERATOR, returnThis);
        }
      }
      // Set @@toStringTag to native iterators
      setToStringTag(CurrentIteratorPrototype, TO_STRING_TAG, true, true);
      if (IS_PURE) Iterators[TO_STRING_TAG] = returnThis;
    }
  }

  // fix Array#{values, @@iterator}.name in V8 / FF
  if (DEFAULT == VALUES && nativeIterator && nativeIterator.name !== VALUES) {
    INCORRECT_VALUES_NAME = true;
    defaultIterator = function values() { return nativeIterator.call(this); };
  }

  // define iterator
  if ((!IS_PURE || FORCED) && IterablePrototype[ITERATOR] !== defaultIterator) {
    createNonEnumerableProperty(IterablePrototype, ITERATOR, defaultIterator);
  }
  Iterators[NAME] = defaultIterator;

  // export additional methods
  if (DEFAULT) {
    methods = {
      values: getIterationMethod(VALUES),
      keys: IS_SET ? defaultIterator : getIterationMethod(KEYS),
      entries: getIterationMethod(ENTRIES)
    };
    if (FORCED) for (KEY in methods) {
      if (BUGGY_SAFARI_ITERATORS || INCORRECT_VALUES_NAME || !(KEY in IterablePrototype)) {
        redefine(IterablePrototype, KEY, methods[KEY]);
      }
    } else $({ target: NAME, proto: true, forced: BUGGY_SAFARI_ITERATORS || INCORRECT_VALUES_NAME }, methods);
  }

  return methods;
};


/***/ }),

/***/ "kjVY":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("Qqkl");
var path = __webpack_require__("j0PW");

module.exports = path.Object.keys;


/***/ }),

/***/ "kpPl":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("VQ32");

/***/ }),

/***/ "kySU":
/***/ (function(module, exports, __webpack_require__) {

var getBuiltIn = __webpack_require__("VCi3");

module.exports = getBuiltIn('document', 'documentElement');


/***/ }),

/***/ "lFsg":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("n9AK");
var $indexOf = __webpack_require__("A551").indexOf;
var arrayMethodIsStrict = __webpack_require__("nSCK");
var arrayMethodUsesToLength = __webpack_require__("ocDp");

var nativeIndexOf = [].indexOf;

var NEGATIVE_ZERO = !!nativeIndexOf && 1 / [1].indexOf(1, -0) < 0;
var STRICT_METHOD = arrayMethodIsStrict('indexOf');
var USES_TO_LENGTH = arrayMethodUsesToLength('indexOf', { ACCESSORS: true, 1: 0 });

// `Array.prototype.indexOf` method
// https://tc39.github.io/ecma262/#sec-array.prototype.indexof
$({ target: 'Array', proto: true, forced: NEGATIVE_ZERO || !STRICT_METHOD || !USES_TO_LENGTH }, {
  indexOf: function indexOf(searchElement /* , fromIndex = 0 */) {
    return NEGATIVE_ZERO
      // convert -0 to +0
      ? nativeIndexOf.apply(this, arguments) || 0
      : $indexOf(this, searchElement, arguments.length > 1 ? arguments[1] : undefined);
  }
});


/***/ }),

/***/ "lOCh":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("lFsg");
var entryVirtual = __webpack_require__("Gfq3");

module.exports = entryVirtual('Array').indexOf;


/***/ }),

/***/ "lWVH":
/***/ (function(module, exports) {

var ceil = Math.ceil;
var floor = Math.floor;

// `ToInteger` abstract operation
// https://tc39.github.io/ecma262/#sec-tointeger
module.exports = function (argument) {
  return isNaN(argument = +argument) ? 0 : (argument > 0 ? floor : ceil)(argument);
};


/***/ }),

/***/ "lbJE":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

// TODO: Remove from `core-js@4` since it's moved to entry points
__webpack_require__("KqXw");
var redefine = __webpack_require__("uLp7");
var fails = __webpack_require__("ct80");
var wellKnownSymbol = __webpack_require__("fVMg");
var regexpExec = __webpack_require__("QsUS");
var createNonEnumerableProperty = __webpack_require__("WxKw");

var SPECIES = wellKnownSymbol('species');

var REPLACE_SUPPORTS_NAMED_GROUPS = !fails(function () {
  // #replace needs built-in support for named groups.
  // #match works fine because it just return the exec results, even if it has
  // a "grops" property.
  var re = /./;
  re.exec = function () {
    var result = [];
    result.groups = { a: '7' };
    return result;
  };
  return ''.replace(re, '$<a>') !== '7';
});

// IE <= 11 replaces $0 with the whole match, as if it was $&
// https://stackoverflow.com/questions/6024666/getting-ie-to-replace-a-regex-with-the-literal-string-0
var REPLACE_KEEPS_$0 = (function () {
  return 'a'.replace(/./, '$0') === '$0';
})();

var REPLACE = wellKnownSymbol('replace');
// Safari <= 13.0.3(?) substitutes nth capture where n>m with an empty string
var REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE = (function () {
  if (/./[REPLACE]) {
    return /./[REPLACE]('a', '$0') === '';
  }
  return false;
})();

// Chrome 51 has a buggy "split" implementation when RegExp#exec !== nativeExec
// Weex JS has frozen built-in prototypes, so use try / catch wrapper
var SPLIT_WORKS_WITH_OVERWRITTEN_EXEC = !fails(function () {
  var re = /(?:)/;
  var originalExec = re.exec;
  re.exec = function () { return originalExec.apply(this, arguments); };
  var result = 'ab'.split(re);
  return result.length !== 2 || result[0] !== 'a' || result[1] !== 'b';
});

module.exports = function (KEY, length, exec, sham) {
  var SYMBOL = wellKnownSymbol(KEY);

  var DELEGATES_TO_SYMBOL = !fails(function () {
    // String methods call symbol-named RegEp methods
    var O = {};
    O[SYMBOL] = function () { return 7; };
    return ''[KEY](O) != 7;
  });

  var DELEGATES_TO_EXEC = DELEGATES_TO_SYMBOL && !fails(function () {
    // Symbol-named RegExp methods call .exec
    var execCalled = false;
    var re = /a/;

    if (KEY === 'split') {
      // We can't use real regex here since it causes deoptimization
      // and serious performance degradation in V8
      // https://github.com/zloirock/core-js/issues/306
      re = {};
      // RegExp[@@split] doesn't call the regex's exec method, but first creates
      // a new one. We need to return the patched regex when creating the new one.
      re.constructor = {};
      re.constructor[SPECIES] = function () { return re; };
      re.flags = '';
      re[SYMBOL] = /./[SYMBOL];
    }

    re.exec = function () { execCalled = true; return null; };

    re[SYMBOL]('');
    return !execCalled;
  });

  if (
    !DELEGATES_TO_SYMBOL ||
    !DELEGATES_TO_EXEC ||
    (KEY === 'replace' && !(
      REPLACE_SUPPORTS_NAMED_GROUPS &&
      REPLACE_KEEPS_$0 &&
      !REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE
    )) ||
    (KEY === 'split' && !SPLIT_WORKS_WITH_OVERWRITTEN_EXEC)
  ) {
    var nativeRegExpMethod = /./[SYMBOL];
    var methods = exec(SYMBOL, ''[KEY], function (nativeMethod, regexp, str, arg2, forceStringMethod) {
      if (regexp.exec === regexpExec) {
        if (DELEGATES_TO_SYMBOL && !forceStringMethod) {
          // The native String method already delegates to @@method (this
          // polyfilled function), leasing to infinite recursion.
          // We avoid it by directly calling the native @@method method.
          return { done: true, value: nativeRegExpMethod.call(regexp, str, arg2) };
        }
        return { done: true, value: nativeMethod.call(str, regexp, arg2) };
      }
      return { done: false };
    }, {
      REPLACE_KEEPS_$0: REPLACE_KEEPS_$0,
      REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE: REGEXP_REPLACE_SUBSTITUTES_UNDEFINED_CAPTURE
    });
    var stringMethod = methods[0];
    var regexMethod = methods[1];

    redefine(String.prototype, KEY, stringMethod);
    redefine(RegExp.prototype, SYMBOL, length == 2
      // 21.2.5.8 RegExp.prototype[@@replace](string, replaceValue)
      // 21.2.5.11 RegExp.prototype[@@split](string, limit)
      ? function (string, arg) { return regexMethod.call(string, this, arg); }
      // 21.2.5.6 RegExp.prototype[@@match](string)
      // 21.2.5.9 RegExp.prototype[@@search](string)
      : function (string) { return regexMethod.call(string, this); }
    );
  }

  if (sham) createNonEnumerableProperty(RegExp.prototype[SYMBOL], 'sham', true);
};


/***/ }),

/***/ "lg3o":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("xQG8");

module.exports = parent;


/***/ }),

/***/ "lhjL":
/***/ (function(module, exports) {

module.exports = function (bitmap, value) {
  return {
    enumerable: !(bitmap & 1),
    configurable: !(bitmap & 2),
    writable: !(bitmap & 4),
    value: value
  };
};


/***/ }),

/***/ "lpqW":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("qWJA");
__webpack_require__("91A9");
__webpack_require__("8bDY");
var WrappedWellKnownSymbolModule = __webpack_require__("wuos");

module.exports = WrappedWellKnownSymbolModule.f('iterator');


/***/ }),

/***/ "lv3h":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var toIndexedObject = __webpack_require__("VcbD");
var addToUnscopables = __webpack_require__("Uh/D");
var Iterators = __webpack_require__("m/wn");
var InternalStateModule = __webpack_require__("WRdu");
var defineIterator = __webpack_require__("kYm/");

var ARRAY_ITERATOR = 'Array Iterator';
var setInternalState = InternalStateModule.set;
var getInternalState = InternalStateModule.getterFor(ARRAY_ITERATOR);

// `Array.prototype.entries` method
// https://tc39.github.io/ecma262/#sec-array.prototype.entries
// `Array.prototype.keys` method
// https://tc39.github.io/ecma262/#sec-array.prototype.keys
// `Array.prototype.values` method
// https://tc39.github.io/ecma262/#sec-array.prototype.values
// `Array.prototype[@@iterator]` method
// https://tc39.github.io/ecma262/#sec-array.prototype-@@iterator
// `CreateArrayIterator` internal method
// https://tc39.github.io/ecma262/#sec-createarrayiterator
module.exports = defineIterator(Array, 'Array', function (iterated, kind) {
  setInternalState(this, {
    type: ARRAY_ITERATOR,
    target: toIndexedObject(iterated), // target
    index: 0,                          // next index
    kind: kind                         // kind
  });
// `%ArrayIteratorPrototype%.next` method
// https://tc39.github.io/ecma262/#sec-%arrayiteratorprototype%.next
}, function () {
  var state = getInternalState(this);
  var target = state.target;
  var kind = state.kind;
  var index = state.index++;
  if (!target || index >= target.length) {
    state.target = undefined;
    return { value: undefined, done: true };
  }
  if (kind == 'keys') return { value: index, done: false };
  if (kind == 'values') return { value: target[index], done: false };
  return { value: [index, target[index]], done: false };
}, 'values');

// argumentsList[@@iterator] is %ArrayProto_values%
// https://tc39.github.io/ecma262/#sec-createunmappedargumentsobject
// https://tc39.github.io/ecma262/#sec-createmappedargumentsobject
Iterators.Arguments = Iterators.Array;

// https://tc39.github.io/ecma262/#sec-array.prototype-@@unscopables
addToUnscopables('keys');
addToUnscopables('values');
addToUnscopables('entries');


/***/ }),

/***/ "lyTg":
/***/ (function(module, exports) {

module.exports = {};


/***/ }),

/***/ "m/b9":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = {
  "map": {
    "en": "map",
    "fr": "carte",
    "es": "mapa",
    "it": "carta",
    "de": "karte",
    "br": "kartenn"
  },
  "passed": {
    "en": "past events",
    "fr": "événements passés",
    "es": "eventos pasados",
    "it": "passato",
    "de": "vergangenheit",
    "br": "darvoudoù tremenet"
  },
  "location": {
    "en": "place",
    "fr": "lieu",
    "es": "lugar",
    "it": "luogo",
    "de": "platz",
    "br": "lec'h"
  },
  "fromTo": {
    "en": "from %start% to %end%",
    "fr": "du %start% au %end%",
    "es": "% De% empezar a% end%",
    "it": "dal %start% al %end%",
    "de": "von %start% bis %end%",
    "br": "eus an %start% d'an %end%"
  }
};

/***/ }),

/***/ "m/wn":
/***/ (function(module, exports) {

module.exports = {};


/***/ }),

/***/ "mVF9":
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__("ct80");
var whitespaces = __webpack_require__("+/eK");

var non = '\u200B\u0085\u180E';

// check that a method works with the correct list
// of whitespaces and has a correct name
module.exports = function (METHOD_NAME) {
  return fails(function () {
    return !!whitespaces[METHOD_NAME]() || non[METHOD_NAME]() != non || whitespaces[METHOD_NAME].name !== METHOD_NAME;
  });
};


/***/ }),

/***/ "mg+6":
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__("i7Kn");

var max = Math.max;
var min = Math.min;

// Helper for a popular repeating case of the spec:
// Let integer be ? ToInteger(index).
// If integer < 0, let result be max((length + integer), 0); else let result be min(integer, length).
module.exports = function (index, length) {
  var integer = toInteger(index);
  return integer < 0 ? max(integer + length, 0) : min(integer, length);
};


/***/ }),

/***/ "mm5/":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("Tycz");
var path = __webpack_require__("j0PW");

module.exports = path.Array.isArray;


/***/ }),

/***/ "mr57":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("kD1X");

/***/ }),

/***/ "mxB3":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("wA+a");
var path = __webpack_require__("j0PW");

module.exports = path.setTimeout;


/***/ }),

/***/ "n1Zv":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("kD1X");

/***/ }),

/***/ "n9AK":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var global = __webpack_require__("oNh+");
var getOwnPropertyDescriptor = __webpack_require__("c9aA").f;
var isForced = __webpack_require__("JCy+");
var path = __webpack_require__("j0PW");
var bind = __webpack_require__("9X0z");
var createNonEnumerableProperty = __webpack_require__("jNzf");
var has = __webpack_require__("zNvU");

var wrapConstructor = function (NativeConstructor) {
  var Wrapper = function (a, b, c) {
    if (this instanceof NativeConstructor) {
      switch (arguments.length) {
        case 0: return new NativeConstructor();
        case 1: return new NativeConstructor(a);
        case 2: return new NativeConstructor(a, b);
      } return new NativeConstructor(a, b, c);
    } return NativeConstructor.apply(this, arguments);
  };
  Wrapper.prototype = NativeConstructor.prototype;
  return Wrapper;
};

/*
  options.target      - name of the target object
  options.global      - target is the global object
  options.stat        - export as static methods of target
  options.proto       - export as prototype methods of target
  options.real        - real prototype method for the `pure` version
  options.forced      - export even if the native feature is available
  options.bind        - bind methods to the target, required for the `pure` version
  options.wrap        - wrap constructors to preventing global pollution, required for the `pure` version
  options.unsafe      - use the simple assignment of property instead of delete + defineProperty
  options.sham        - add a flag to not completely full polyfills
  options.enumerable  - export as enumerable property
  options.noTargetGet - prevent calling a getter on target
*/
module.exports = function (options, source) {
  var TARGET = options.target;
  var GLOBAL = options.global;
  var STATIC = options.stat;
  var PROTO = options.proto;

  var nativeSource = GLOBAL ? global : STATIC ? global[TARGET] : (global[TARGET] || {}).prototype;

  var target = GLOBAL ? path : path[TARGET] || (path[TARGET] = {});
  var targetPrototype = target.prototype;

  var FORCED, USE_NATIVE, VIRTUAL_PROTOTYPE;
  var key, sourceProperty, targetProperty, nativeProperty, resultProperty, descriptor;

  for (key in source) {
    FORCED = isForced(GLOBAL ? key : TARGET + (STATIC ? '.' : '#') + key, options.forced);
    // contains in native
    USE_NATIVE = !FORCED && nativeSource && has(nativeSource, key);

    targetProperty = target[key];

    if (USE_NATIVE) if (options.noTargetGet) {
      descriptor = getOwnPropertyDescriptor(nativeSource, key);
      nativeProperty = descriptor && descriptor.value;
    } else nativeProperty = nativeSource[key];

    // export native or implementation
    sourceProperty = (USE_NATIVE && nativeProperty) ? nativeProperty : source[key];

    if (USE_NATIVE && typeof targetProperty === typeof sourceProperty) continue;

    // bind timers to global for call from export context
    if (options.bind && USE_NATIVE) resultProperty = bind(sourceProperty, global);
    // wrap global constructors for prevent changs in this version
    else if (options.wrap && USE_NATIVE) resultProperty = wrapConstructor(sourceProperty);
    // make static versions for prototype methods
    else if (PROTO && typeof sourceProperty == 'function') resultProperty = bind(Function.call, sourceProperty);
    // default case
    else resultProperty = sourceProperty;

    // add a flag to not completely full polyfills
    if (options.sham || (sourceProperty && sourceProperty.sham) || (targetProperty && targetProperty.sham)) {
      createNonEnumerableProperty(resultProperty, 'sham', true);
    }

    target[key] = resultProperty;

    if (PROTO) {
      VIRTUAL_PROTOTYPE = TARGET + 'Prototype';
      if (!has(path, VIRTUAL_PROTOTYPE)) {
        createNonEnumerableProperty(path, VIRTUAL_PROTOTYPE, {});
      }
      // export virtual prototype methods
      path[VIRTUAL_PROTOTYPE][key] = sourceProperty;
      // export real prototype methods
      if (options.real && targetPrototype && !targetPrototype[key]) {
        createNonEnumerableProperty(targetPrototype, key, sourceProperty);
      }
    }
  }
};


/***/ }),

/***/ "nB+7":
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__("XU0c");
var wellKnownSymbol = __webpack_require__("HVcX");
var V8_VERSION = __webpack_require__("Qb90");

var SPECIES = wellKnownSymbol('species');

module.exports = function (METHOD_NAME) {
  // We can't use this feature detection in V8 since it causes
  // deoptimization and serious performance degradation
  // https://github.com/zloirock/core-js/issues/677
  return V8_VERSION >= 51 || !fails(function () {
    var array = [];
    var constructor = array.constructor = {};
    constructor[SPECIES] = function () {
      return { foo: 1 };
    };
    return array[METHOD_NAME](Boolean).foo !== 1;
  });
};


/***/ }),

/***/ "nKVx":
/***/ (function(module, exports, __webpack_require__) {

var internalObjectKeys = __webpack_require__("0fQ6");
var enumBugKeys = __webpack_require__("yk1j");

// `Object.keys` method
// https://tc39.github.io/ecma262/#sec-object.keys
module.exports = Object.keys || function keys(O) {
  return internalObjectKeys(O, enumBugKeys);
};


/***/ }),

/***/ "nSCK":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var fails = __webpack_require__("XU0c");

module.exports = function (METHOD_NAME, argument) {
  var method = [][METHOD_NAME];
  return !!method && fails(function () {
    // eslint-disable-next-line no-useless-call,no-throw-literal
    method.call(null, argument || function () { throw 1; }, 1);
  });
};


/***/ }),

/***/ "nVA8":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("yFGb");
var entryVirtual = __webpack_require__("Gfq3");

module.exports = entryVirtual('Array').splice;


/***/ }),

/***/ "oD4t":
/***/ (function(module, exports, __webpack_require__) {

var getBuiltIn = __webpack_require__("VCi3");
var getOwnPropertyNamesModule = __webpack_require__("ZdBB");
var getOwnPropertySymbolsModule = __webpack_require__("JAL5");
var anObject = __webpack_require__("FXyv");

// all object keys, includes non-enumerable and symbols
module.exports = getBuiltIn('Reflect', 'ownKeys') || function ownKeys(it) {
  var keys = getOwnPropertyNamesModule.f(anObject(it));
  var getOwnPropertySymbols = getOwnPropertySymbolsModule.f;
  return getOwnPropertySymbols ? keys.concat(getOwnPropertySymbols(it)) : keys;
};


/***/ }),

/***/ "oKMU":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.matchAll` well-known symbol
defineWellKnownSymbol('matchAll');


/***/ }),

/***/ "oNh+":
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {var check = function (it) {
  return it && it.Math == Math && it;
};

// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
module.exports =
  // eslint-disable-next-line no-undef
  check(typeof globalThis == 'object' && globalThis) ||
  check(typeof window == 'object' && window) ||
  check(typeof self == 'object' && self) ||
  check(typeof global == 'object' && global) ||
  // eslint-disable-next-line no-new-func
  Function('return this')();

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__("fRV1")))

/***/ }),

/***/ "ocDp":
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__("5Jdw");
var fails = __webpack_require__("XU0c");
var has = __webpack_require__("zNvU");

var defineProperty = Object.defineProperty;
var cache = {};

var thrower = function (it) { throw it; };

module.exports = function (METHOD_NAME, options) {
  if (has(cache, METHOD_NAME)) return cache[METHOD_NAME];
  if (!options) options = {};
  var method = [][METHOD_NAME];
  var ACCESSORS = has(options, 'ACCESSORS') ? options.ACCESSORS : false;
  var argument0 = has(options, 0) ? options[0] : thrower;
  var argument1 = has(options, 1) ? options[1] : undefined;

  return cache[METHOD_NAME] = !!method && !fails(function () {
    if (ACCESSORS && !DESCRIPTORS) return true;
    var O = { length: -1 };

    if (ACCESSORS) defineProperty(O, 1, { enumerable: true, get: thrower });
    else O[1] = 1;

    method.call(O, argument0, argument1);
  });
};


/***/ }),

/***/ "p7Hb":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("n9AK");
var aFunction = __webpack_require__("5ntg");
var toObject = __webpack_require__("quhl");
var fails = __webpack_require__("XU0c");
var arrayMethodIsStrict = __webpack_require__("nSCK");

var test = [];
var nativeSort = test.sort;

// IE8-
var FAILS_ON_UNDEFINED = fails(function () {
  test.sort(undefined);
});
// V8 bug
var FAILS_ON_NULL = fails(function () {
  test.sort(null);
});
// Old WebKit
var STRICT_METHOD = arrayMethodIsStrict('sort');

var FORCED = FAILS_ON_UNDEFINED || !FAILS_ON_NULL || !STRICT_METHOD;

// `Array.prototype.sort` method
// https://tc39.github.io/ecma262/#sec-array.prototype.sort
$({ target: 'Array', proto: true, forced: FORCED }, {
  sort: function sort(comparefn) {
    return comparefn === undefined
      ? nativeSort.call(toObject(this))
      : nativeSort.call(toObject(this), aFunction(comparefn));
  }
});


/***/ }),

/***/ "p853":
/***/ (function(module, exports, __webpack_require__) {

var _Symbol$iterator = __webpack_require__("n1Zv");

var _Symbol = __webpack_require__("s3Nl");

function _typeof(obj) {
  "@babel/helpers - typeof";

  if (typeof _Symbol === "function" && typeof _Symbol$iterator === "symbol") {
    module.exports = _typeof = function _typeof(obj) {
      return typeof obj;
    };
  } else {
    module.exports = _typeof = function _typeof(obj) {
      return obj && typeof _Symbol === "function" && obj.constructor === _Symbol && obj !== _Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}

module.exports = _typeof;

/***/ }),

/***/ "pu3o":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var stringify = __webpack_require__("SYP+");
var parse = __webpack_require__("w7lK");
var formats = __webpack_require__("cYYr");

module.exports = {
    formats: formats,
    parse: parse,
    stringify: stringify
};


/***/ }),

/***/ "pzYf":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("I9Ws");

/***/ }),

/***/ "q/0V":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var anObject = __webpack_require__("FXyv");

// `RegExp.prototype.flags` getter implementation
// https://tc39.github.io/ecma262/#sec-get-regexp.prototype.flags
module.exports = function () {
  var that = anObject(this);
  var result = '';
  if (that.global) result += 'g';
  if (that.ignoreCase) result += 'i';
  if (that.multiline) result += 'm';
  if (that.dotAll) result += 's';
  if (that.unicode) result += 'u';
  if (that.sticky) result += 'y';
  return result;
};


/***/ }),

/***/ "q9+l":
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__("1Mu/");
var IE8_DOM_DEFINE = __webpack_require__("fD9S");
var anObject = __webpack_require__("FXyv");
var toPrimitive = __webpack_require__("CD8Q");

var nativeDefineProperty = Object.defineProperty;

// `Object.defineProperty` method
// https://tc39.github.io/ecma262/#sec-object.defineproperty
exports.f = DESCRIPTORS ? nativeDefineProperty : function defineProperty(O, P, Attributes) {
  anObject(O);
  P = toPrimitive(P, true);
  anObject(Attributes);
  if (IE8_DOM_DEFINE) try {
    return nativeDefineProperty(O, P, Attributes);
  } catch (error) { /* empty */ }
  if ('get' in Attributes || 'set' in Attributes) throw TypeError('Accessors not supported');
  if ('value' in Attributes) O[P] = Attributes.value;
  return O;
};


/***/ }),

/***/ "qCBb":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.dispose` well-known symbol
// https://github.com/tc39/proposal-using-statement
defineWellKnownSymbol('dispose');


/***/ }),

/***/ "qWJA":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.iterator` well-known symbol
// https://tc39.github.io/ecma262/#sec-symbol.iterator
defineWellKnownSymbol('iterator');


/***/ }),

/***/ "quhl":
/***/ (function(module, exports, __webpack_require__) {

var requireObjectCoercible = __webpack_require__("j0cD");

// `ToObject` abstract operation
// https://tc39.github.io/ecma262/#sec-toobject
module.exports = function (argument) {
  return Object(requireObjectCoercible(argument));
};


/***/ }),

/***/ "r/P8":
/***/ (function(module, exports, __webpack_require__) {

var TO_STRING_TAG_SUPPORT = __webpack_require__("WbkG");
var classofRaw = __webpack_require__("WTd3");
var wellKnownSymbol = __webpack_require__("HVcX");

var TO_STRING_TAG = wellKnownSymbol('toStringTag');
// ES3 wrong here
var CORRECT_ARGUMENTS = classofRaw(function () { return arguments; }()) == 'Arguments';

// fallback for IE11 Script Access Denied error
var tryGet = function (it, key) {
  try {
    return it[key];
  } catch (error) { /* empty */ }
};

// getting tag from ES6+ `Object.prototype.toString`
module.exports = TO_STRING_TAG_SUPPORT ? classofRaw : function (it) {
  var O, tag, result;
  return it === undefined ? 'Undefined' : it === null ? 'Null'
    // @@toStringTag case
    : typeof (tag = tryGet(O = Object(it), TO_STRING_TAG)) == 'string' ? tag
    // builtinTag case
    : CORRECT_ARGUMENTS ? classofRaw(O)
    // ES3 arguments fallback
    : (result = classofRaw(O)) == 'Object' && typeof O.callee == 'function' ? 'Arguments' : result;
};


/***/ }),

/***/ "r89b":
/***/ (function(module, exports, __webpack_require__) {

var map = __webpack_require__("GnwC");

var ArrayPrototype = Array.prototype;

module.exports = function (it) {
  var own = it.map;
  return it === ArrayPrototype || (it instanceof Array && own === ArrayPrototype.map) ? map : own;
};


/***/ }),

/***/ "s3Nl":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("I9Ws");

/***/ }),

/***/ "sJY8":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("p7Hb");
var entryVirtual = __webpack_require__("Gfq3");

module.exports = entryVirtual('Array').sort;


/***/ }),

/***/ "sX5C":
/***/ (function(module, exports) {

// IE8- don't enum bug keys
module.exports = [
  'constructor',
  'hasOwnProperty',
  'isPrototypeOf',
  'propertyIsEnumerable',
  'toLocaleString',
  'toString',
  'valueOf'
];


/***/ }),

/***/ "t/tF":
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__("i7Kn");
var requireObjectCoercible = __webpack_require__("cww3");

// `String.prototype.{ codePointAt, at }` methods implementation
var createMethod = function (CONVERT_TO_STRING) {
  return function ($this, pos) {
    var S = String(requireObjectCoercible($this));
    var position = toInteger(pos);
    var size = S.length;
    var first, second;
    if (position < 0 || position >= size) return CONVERT_TO_STRING ? '' : undefined;
    first = S.charCodeAt(position);
    return first < 0xD800 || first > 0xDBFF || position + 1 === size
      || (second = S.charCodeAt(position + 1)) < 0xDC00 || second > 0xDFFF
        ? CONVERT_TO_STRING ? S.charAt(position) : first
        : CONVERT_TO_STRING ? S.slice(position, position + 2) : (first - 0xD800 << 10) + (second - 0xDC00) + 0x10000;
  };
};

module.exports = {
  // `String.prototype.codePointAt` method
  // https://tc39.github.io/ecma262/#sec-string.prototype.codepointat
  codeAt: createMethod(false),
  // `String.prototype.at` method
  // https://github.com/mathiasbynens/String.prototype.at
  charAt: createMethod(true)
};


/***/ }),

/***/ "tC4N":
/***/ (function(module, exports, __webpack_require__) {

var sort = __webpack_require__("sJY8");

var ArrayPrototype = Array.prototype;

module.exports = function (it) {
  var own = it.sort;
  return it === ArrayPrototype || (it instanceof Array && own === ArrayPrototype.sort) ? sort : own;
};


/***/ }),

/***/ "tCEB":
/***/ (function(module, exports, __webpack_require__) {

var path = __webpack_require__("j0PW");
var has = __webpack_require__("zNvU");
var wrappedWellKnownSymbolModule = __webpack_require__("wuos");
var defineProperty = __webpack_require__("JliG").f;

module.exports = function (NAME) {
  var Symbol = path.Symbol || (path.Symbol = {});
  if (!has(Symbol, NAME)) defineProperty(Symbol, NAME, {
    value: wrappedWellKnownSymbolModule.f(NAME)
  });
};


/***/ }),

/***/ "tJVe":
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__("i7Kn");

var min = Math.min;

// `ToLength` abstract operation
// https://tc39.github.io/ecma262/#sec-tolength
module.exports = function (argument) {
  return argument > 0 ? min(toInteger(argument), 0x1FFFFFFFFFFFFF) : 0; // 2 ** 53 - 1 == 9007199254740991
};


/***/ }),

/***/ "tTj0":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("bUrk");

module.exports = parent;


/***/ }),

/***/ "tVqn":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("ax0f");
var $trim = __webpack_require__("Ya2h").trim;
var forcedStringTrimMethod = __webpack_require__("mVF9");

// `String.prototype.trim` method
// https://tc39.github.io/ecma262/#sec-string.prototype.trim
$({ target: 'String', proto: true, forced: forcedStringTrimMethod('trim') }, {
  trim: function trim() {
    return $trim(this);
  }
});


/***/ }),

/***/ "tfi8":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("ft9U");

/***/ }),

/***/ "tjTa":
/***/ (function(module, exports, __webpack_require__) {

var has = __webpack_require__("8aeu");
var ownKeys = __webpack_require__("oD4t");
var getOwnPropertyDescriptorModule = __webpack_require__("GFpt");
var definePropertyModule = __webpack_require__("q9+l");

module.exports = function (target, source) {
  var keys = ownKeys(source);
  var defineProperty = definePropertyModule.f;
  var getOwnPropertyDescriptor = getOwnPropertyDescriptorModule.f;
  for (var i = 0; i < keys.length; i++) {
    var key = keys[i];
    if (!has(target, key)) defineProperty(target, key, getOwnPropertyDescriptor(source, key));
  }
};


/***/ }),

/***/ "uK0S":
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__("5Jdw");
var definePropertyModule = __webpack_require__("JliG");
var anObject = __webpack_require__("LTNl");
var objectKeys = __webpack_require__("nKVx");

// `Object.defineProperties` method
// https://tc39.github.io/ecma262/#sec-object.defineproperties
module.exports = DESCRIPTORS ? Object.defineProperties : function defineProperties(O, Properties) {
  anObject(O);
  var keys = objectKeys(Properties);
  var length = keys.length;
  var index = 0;
  var key;
  while (length > index) definePropertyModule.f(O, key = keys[index++], Properties[key]);
  return O;
};


/***/ }),

/***/ "uLp7":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("9JhN");
var createNonEnumerableProperty = __webpack_require__("WxKw");
var has = __webpack_require__("8aeu");
var setGlobal = __webpack_require__("PjRa");
var inspectSource = __webpack_require__("32/0");
var InternalStateModule = __webpack_require__("zc29");

var getInternalState = InternalStateModule.get;
var enforceInternalState = InternalStateModule.enforce;
var TEMPLATE = String(String).split('String');

(module.exports = function (O, key, value, options) {
  var unsafe = options ? !!options.unsafe : false;
  var simple = options ? !!options.enumerable : false;
  var noTargetGet = options ? !!options.noTargetGet : false;
  if (typeof value == 'function') {
    if (typeof key == 'string' && !has(value, 'name')) createNonEnumerableProperty(value, 'name', key);
    enforceInternalState(value).source = TEMPLATE.join(typeof key == 'string' ? key : '');
  }
  if (O === global) {
    if (simple) O[key] = value;
    else setGlobal(key, value);
    return;
  } else if (!unsafe) {
    delete O[key];
  } else if (!noTargetGet && O[key]) {
    simple = true;
  }
  if (simple) O[key] = value;
  else createNonEnumerableProperty(O, key, value);
// add fake Function#toString for correct work wrapped methods / constructors with methods like LoDash isNative
})(Function.prototype, 'toString', function toString() {
  return typeof this == 'function' && getInternalState(this).source || inspectSource(this);
});


/***/ }),

/***/ "uZvN":
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__("1Mu/");
var definePropertyModule = __webpack_require__("q9+l");
var anObject = __webpack_require__("FXyv");
var objectKeys = __webpack_require__("DEeE");

// `Object.defineProperties` method
// https://tc39.github.io/ecma262/#sec-object.defineproperties
module.exports = DESCRIPTORS ? Object.defineProperties : function defineProperties(O, Properties) {
  anObject(O);
  var keys = objectKeys(Properties);
  var length = keys.length;
  var index = 0;
  var key;
  while (length > index) definePropertyModule.f(O, key = keys[index++], Properties[key]);
  return O;
};


/***/ }),

/***/ "uoFg":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("dLyh");
var entryVirtual = __webpack_require__("Gfq3");

module.exports = entryVirtual('Array').slice;


/***/ }),

/***/ "utRA":
/***/ (function(module, exports) {

module.exports = function anonymous(locals, escapeFn, include, rethrow) {
    rethrow = rethrow || function rethrow(err, str, flnm, lineno, esc) {
        var lines = str.split("\n");
        var start = Math.max(lineno - 3, 0);
        var end = Math.min(lines.length, lineno + 3);
        var filename = esc(flnm);
        var context = lines.slice(start, end).map(function(line, i) {
            var curr = i + start + 1;
            return (curr == lineno ? " >> " : "    ") + curr + "| " + line;
        }).join("\n");
        err.path = filename;
        err.message = (filename || "ejs") + ":" + lineno + "\n" + context + "\n\n" + err.message;
        throw err;
    };
    escapeFn = escapeFn || function(markup) {
        return markup == undefined ? "" : String(markup).replace(_MATCH_HTML, encode_char);
    };
    var _ENCODE_HTML_RULES = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&#34;",
        "'": "&#39;"
    }, _MATCH_HTML = /[&<>'"]/g;
    function encode_char(c) {
        return _ENCODE_HTML_RULES[c] || c;
    }
    var __line = 1, __lines = '<li class="oa-filter-<%- type %>"><span><%= label %></span><a>&#10005</a></li>', __filename = "widgets/activeFilters/item.ejs";
    try {
        var __output = "";
        function __append(s) {
            if (s !== undefined && s !== null) __output += s;
        }
        with (locals || {}) {
            __append('<li class="oa-filter-');
            __append(type);
            __append('"><span>');
            __append(escapeFn(label));
            __append("</span><a>&#10005</a></li>");
        }
        return __output;
    } catch (e) {
        rethrow(e, __lines, __filename, __line, escapeFn);
    }
}

/***/ }),

/***/ "uuWK":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("r89b");

module.exports = parent;


/***/ }),

/***/ "v7GL":
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__("n9AK");
var DESCRIPTORS = __webpack_require__("5Jdw");
var create = __webpack_require__("By9b");

// `Object.create` method
// https://tc39.github.io/ecma262/#sec-object.create
$({ target: 'Object', stat: true, sham: !DESCRIPTORS }, {
  create: create
});


/***/ }),

/***/ "vBaQ":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("I9Ws");

/***/ }),

/***/ "vFRI":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("Q+0L");

module.exports = parent;


/***/ }),

/***/ "vGD7":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("b+9f");

/***/ }),

/***/ "vMH7":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__("KqXw");

__webpack_require__("MvUL");

var _someInstanceProperty = __webpack_require__("RkMe");

var _indexOfInstanceProperty = __webpack_require__("M6xr");

var IntlMessageFormat = __webpack_require__("C36Y").default;

var parser = __webpack_require__("fZb7");
/**
 * provide a labels getter that will
 * give back labels fed at init
 *
 * needs to be ES5 or cibul-templates uglify will throw errors
 */


module.exports = function (labels, defaultLang, fallbackLang) {
  if (typeof defaultLang === 'undefined') {
    defaultLang = 'en';
  }

  if (typeof fallbackLang === 'undefined') {
    fallbackLang = 'en';
  }

  var getLabel = function getLabel(name, values, lang) {
    var _context;

    if (arguments.length == 2 && typeof values == 'string') {
      lang = values;
      values = {};
    }

    if (!lang) {
      lang = defaultLang;
    }

    if (!labels[name]) {
      return null;
    }

    var str = _indexOfInstanceProperty(_context = [undefined, null]).call(_context, labels[name][lang]) === -1 ? labels[name][lang] : null;

    if (fallbackLang && !str) {
      str = labels[name][fallbackLang];
    }

    if (!str) {
      str = name;
    }

    try {
      var parsedAST = parser.parse(str);

      var isICU = _someInstanceProperty(parsedAST).call(parsedAST, function (v) {
        return !parser.isLiteralElement(v);
      }); // ICU message


      if (isICU) {
        return new IntlMessageFormat(parsedAST, lang).format(values);
      }
    } catch (e) {//
    }

    str = str.replace(/\'\'/gm, '\''); // Old API - if ( str.match( /%\w+%/ ) ) {}

    if (values) {
      for (var k in values) {
        str = str.replace('%' + k + '%', values[k]);
      }
    }

    return str;
  };

  getLabel.labels = labels;
  return getLabel;
};

/***/ }),

/***/ "w7lK":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__("V/Lb");

var has = Object.prototype.hasOwnProperty;
var isArray = Array.isArray;

var defaults = {
    allowDots: false,
    allowPrototypes: false,
    arrayLimit: 20,
    charset: 'utf-8',
    charsetSentinel: false,
    comma: false,
    decoder: utils.decode,
    delimiter: '&',
    depth: 5,
    ignoreQueryPrefix: false,
    interpretNumericEntities: false,
    parameterLimit: 1000,
    parseArrays: true,
    plainObjects: false,
    strictNullHandling: false
};

var interpretNumericEntities = function (str) {
    return str.replace(/&#(\d+);/g, function ($0, numberStr) {
        return String.fromCharCode(parseInt(numberStr, 10));
    });
};

// This is what browsers will submit when the ✓ character occurs in an
// application/x-www-form-urlencoded body and the encoding of the page containing
// the form is iso-8859-1, or when the submitted form has an accept-charset
// attribute of iso-8859-1. Presumably also with other charsets that do not contain
// the ✓ character, such as us-ascii.
var isoSentinel = 'utf8=%26%2310003%3B'; // encodeURIComponent('&#10003;')

// These are the percent-encoded utf-8 octets representing a checkmark, indicating that the request actually is utf-8 encoded.
var charsetSentinel = 'utf8=%E2%9C%93'; // encodeURIComponent('✓')

var parseValues = function parseQueryStringValues(str, options) {
    var obj = {};
    var cleanStr = options.ignoreQueryPrefix ? str.replace(/^\?/, '') : str;
    var limit = options.parameterLimit === Infinity ? undefined : options.parameterLimit;
    var parts = cleanStr.split(options.delimiter, limit);
    var skipIndex = -1; // Keep track of where the utf8 sentinel was found
    var i;

    var charset = options.charset;
    if (options.charsetSentinel) {
        for (i = 0; i < parts.length; ++i) {
            if (parts[i].indexOf('utf8=') === 0) {
                if (parts[i] === charsetSentinel) {
                    charset = 'utf-8';
                } else if (parts[i] === isoSentinel) {
                    charset = 'iso-8859-1';
                }
                skipIndex = i;
                i = parts.length; // The eslint settings do not allow break;
            }
        }
    }

    for (i = 0; i < parts.length; ++i) {
        if (i === skipIndex) {
            continue;
        }
        var part = parts[i];

        var bracketEqualsPos = part.indexOf(']=');
        var pos = bracketEqualsPos === -1 ? part.indexOf('=') : bracketEqualsPos + 1;

        var key, val;
        if (pos === -1) {
            key = options.decoder(part, defaults.decoder, charset, 'key');
            val = options.strictNullHandling ? null : '';
        } else {
            key = options.decoder(part.slice(0, pos), defaults.decoder, charset, 'key');
            val = options.decoder(part.slice(pos + 1), defaults.decoder, charset, 'value');
        }

        if (val && options.interpretNumericEntities && charset === 'iso-8859-1') {
            val = interpretNumericEntities(val);
        }

        if (val && typeof val === 'string' && options.comma && val.indexOf(',') > -1) {
            val = val.split(',');
        }

        if (part.indexOf('[]=') > -1) {
            val = isArray(val) ? [val] : val;
        }

        if (has.call(obj, key)) {
            obj[key] = utils.combine(obj[key], val);
        } else {
            obj[key] = val;
        }
    }

    return obj;
};

var parseObject = function (chain, val, options) {
    var leaf = val;

    for (var i = chain.length - 1; i >= 0; --i) {
        var obj;
        var root = chain[i];

        if (root === '[]' && options.parseArrays) {
            obj = [].concat(leaf);
        } else {
            obj = options.plainObjects ? Object.create(null) : {};
            var cleanRoot = root.charAt(0) === '[' && root.charAt(root.length - 1) === ']' ? root.slice(1, -1) : root;
            var index = parseInt(cleanRoot, 10);
            if (!options.parseArrays && cleanRoot === '') {
                obj = { 0: leaf };
            } else if (
                !isNaN(index)
                && root !== cleanRoot
                && String(index) === cleanRoot
                && index >= 0
                && (options.parseArrays && index <= options.arrayLimit)
            ) {
                obj = [];
                obj[index] = leaf;
            } else {
                obj[cleanRoot] = leaf;
            }
        }

        leaf = obj;
    }

    return leaf;
};

var parseKeys = function parseQueryStringKeys(givenKey, val, options) {
    if (!givenKey) {
        return;
    }

    // Transform dot notation to bracket notation
    var key = options.allowDots ? givenKey.replace(/\.([^.[]+)/g, '[$1]') : givenKey;

    // The regex chunks

    var brackets = /(\[[^[\]]*])/;
    var child = /(\[[^[\]]*])/g;

    // Get the parent

    var segment = options.depth > 0 && brackets.exec(key);
    var parent = segment ? key.slice(0, segment.index) : key;

    // Stash the parent if it exists

    var keys = [];
    if (parent) {
        // If we aren't using plain objects, optionally prefix keys that would overwrite object prototype properties
        if (!options.plainObjects && has.call(Object.prototype, parent)) {
            if (!options.allowPrototypes) {
                return;
            }
        }

        keys.push(parent);
    }

    // Loop through children appending to the array until we hit depth

    var i = 0;
    while (options.depth > 0 && (segment = child.exec(key)) !== null && i < options.depth) {
        i += 1;
        if (!options.plainObjects && has.call(Object.prototype, segment[1].slice(1, -1))) {
            if (!options.allowPrototypes) {
                return;
            }
        }
        keys.push(segment[1]);
    }

    // If there's a remainder, just add whatever is left

    if (segment) {
        keys.push('[' + key.slice(segment.index) + ']');
    }

    return parseObject(keys, val, options);
};

var normalizeParseOptions = function normalizeParseOptions(opts) {
    if (!opts) {
        return defaults;
    }

    if (opts.decoder !== null && opts.decoder !== undefined && typeof opts.decoder !== 'function') {
        throw new TypeError('Decoder has to be a function.');
    }

    if (typeof opts.charset !== 'undefined' && opts.charset !== 'utf-8' && opts.charset !== 'iso-8859-1') {
        throw new Error('The charset option must be either utf-8, iso-8859-1, or undefined');
    }
    var charset = typeof opts.charset === 'undefined' ? defaults.charset : opts.charset;

    return {
        allowDots: typeof opts.allowDots === 'undefined' ? defaults.allowDots : !!opts.allowDots,
        allowPrototypes: typeof opts.allowPrototypes === 'boolean' ? opts.allowPrototypes : defaults.allowPrototypes,
        arrayLimit: typeof opts.arrayLimit === 'number' ? opts.arrayLimit : defaults.arrayLimit,
        charset: charset,
        charsetSentinel: typeof opts.charsetSentinel === 'boolean' ? opts.charsetSentinel : defaults.charsetSentinel,
        comma: typeof opts.comma === 'boolean' ? opts.comma : defaults.comma,
        decoder: typeof opts.decoder === 'function' ? opts.decoder : defaults.decoder,
        delimiter: typeof opts.delimiter === 'string' || utils.isRegExp(opts.delimiter) ? opts.delimiter : defaults.delimiter,
        // eslint-disable-next-line no-implicit-coercion, no-extra-parens
        depth: (typeof opts.depth === 'number' || opts.depth === false) ? +opts.depth : defaults.depth,
        ignoreQueryPrefix: opts.ignoreQueryPrefix === true,
        interpretNumericEntities: typeof opts.interpretNumericEntities === 'boolean' ? opts.interpretNumericEntities : defaults.interpretNumericEntities,
        parameterLimit: typeof opts.parameterLimit === 'number' ? opts.parameterLimit : defaults.parameterLimit,
        parseArrays: opts.parseArrays !== false,
        plainObjects: typeof opts.plainObjects === 'boolean' ? opts.plainObjects : defaults.plainObjects,
        strictNullHandling: typeof opts.strictNullHandling === 'boolean' ? opts.strictNullHandling : defaults.strictNullHandling
    };
};

module.exports = function (str, opts) {
    var options = normalizeParseOptions(opts);

    if (str === '' || str === null || typeof str === 'undefined') {
        return options.plainObjects ? Object.create(null) : {};
    }

    var tempObj = typeof str === 'string' ? parseValues(str, options) : str;
    var obj = options.plainObjects ? Object.create(null) : {};

    // Iterate over the keys and setup the new object

    var keys = Object.keys(tempObj);
    for (var i = 0; i < keys.length; ++i) {
        var key = keys[i];
        var newObj = parseKeys(key, tempObj[key], options);
        obj = utils.merge(obj, newObj, options);
    }

    return utils.compact(obj);
};


/***/ }),

/***/ "wA+a":
/***/ (function(module, exports, __webpack_require__) {

var $ = __webpack_require__("n9AK");
var global = __webpack_require__("oNh+");
var userAgent = __webpack_require__("9eyx");

var slice = [].slice;
var MSIE = /MSIE .\./.test(userAgent); // <- dirty ie9- check

var wrap = function (scheduler) {
  return function (handler, timeout /* , ...arguments */) {
    var boundArgs = arguments.length > 2;
    var args = boundArgs ? slice.call(arguments, 2) : undefined;
    return scheduler(boundArgs ? function () {
      // eslint-disable-next-line no-new-func
      (typeof handler == 'function' ? handler : Function(handler)).apply(this, args);
    } : handler, timeout);
  };
};

// ie9- setTimeout & setInterval additional parameters fix
// https://html.spec.whatwg.org/multipage/timers-and-user-prompts.html#timers
$({ global: true, bind: true, forced: MSIE }, {
  // `setTimeout` method
  // https://html.spec.whatwg.org/multipage/timers-and-user-prompts.html#dom-settimeout
  setTimeout: wrap(global.setTimeout),
  // `setInterval` method
  // https://html.spec.whatwg.org/multipage/timers-and-user-prompts.html#dom-setinterval
  setInterval: wrap(global.setInterval)
});


/***/ }),

/***/ "wF8L":
/***/ (function(module, exports, __webpack_require__) {

var path = __webpack_require__("j0PW");
var global = __webpack_require__("oNh+");

var aFunction = function (variable) {
  return typeof variable == 'function' ? variable : undefined;
};

module.exports = function (namespace, method) {
  return arguments.length < 2 ? aFunction(path[namespace]) || aFunction(global[namespace])
    : path[namespace] && path[namespace][method] || global[namespace] && global[namespace][method];
};


/***/ }),

/***/ "wXON":
/***/ (function(module, exports, __webpack_require__) {

var anObject = __webpack_require__("LTNl");
var aPossiblePrototype = __webpack_require__("E8k3");

// `Object.setPrototypeOf` method
// https://tc39.github.io/ecma262/#sec-object.setprototypeof
// Works with __proto__ only. Old v8 can't work with null proto objects.
/* eslint-disable no-proto */
module.exports = Object.setPrototypeOf || ('__proto__' in {} ? function () {
  var CORRECT_SETTER = false;
  var test = {};
  var setter;
  try {
    setter = Object.getOwnPropertyDescriptor(Object.prototype, '__proto__').set;
    setter.call(test, []);
    CORRECT_SETTER = test instanceof Array;
  } catch (error) { /* empty */ }
  return function setPrototypeOf(O, proto) {
    anObject(O);
    aPossiblePrototype(proto);
    if (CORRECT_SETTER) setter.call(O, proto);
    else O.__proto__ = proto;
    return O;
  };
}() : undefined);


/***/ }),

/***/ "waID":
/***/ (function(module, exports, __webpack_require__) {

var anObject = __webpack_require__("FXyv");
var aPossiblePrototype = __webpack_require__("8+RD");

// `Object.setPrototypeOf` method
// https://tc39.github.io/ecma262/#sec-object.setprototypeof
// Works with __proto__ only. Old v8 can't work with null proto objects.
/* eslint-disable no-proto */
module.exports = Object.setPrototypeOf || ('__proto__' in {} ? function () {
  var CORRECT_SETTER = false;
  var test = {};
  var setter;
  try {
    setter = Object.getOwnPropertyDescriptor(Object.prototype, '__proto__').set;
    setter.call(test, []);
    CORRECT_SETTER = test instanceof Array;
  } catch (error) { /* empty */ }
  return function setPrototypeOf(O, proto) {
    anObject(O);
    aPossiblePrototype(proto);
    if (CORRECT_SETTER) setter.call(O, proto);
    else O.__proto__ = proto;
    return O;
  };
}() : undefined);


/***/ }),

/***/ "wiNy":
/***/ (function(module, exports, __webpack_require__) {

var _Symbol$iterator = __webpack_require__("mr57");

var _Symbol = __webpack_require__("vBaQ");

function _typeof(obj) {
  "@babel/helpers - typeof";

  if (typeof _Symbol === "function" && typeof _Symbol$iterator === "symbol") {
    module.exports = _typeof = function _typeof(obj) {
      return typeof obj;
    };
  } else {
    module.exports = _typeof = function _typeof(obj) {
      return obj && typeof _Symbol === "function" && obj.constructor === _Symbol && obj !== _Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}

module.exports = _typeof;

/***/ }),

/***/ "wkL6":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("C0uO");

module.exports = parent;


/***/ }),

/***/ "wuos":
/***/ (function(module, exports, __webpack_require__) {

var wellKnownSymbol = __webpack_require__("HVcX");

exports.f = wellKnownSymbol;


/***/ }),

/***/ "x+gH":
/***/ (function(module, exports, __webpack_require__) {

var internalObjectKeys = __webpack_require__("0fQ6");
var enumBugKeys = __webpack_require__("yk1j");

var hiddenKeys = enumBugKeys.concat('length', 'prototype');

// `Object.getOwnPropertyNames` method
// https://tc39.github.io/ecma262/#sec-object.getownpropertynames
exports.f = Object.getOwnPropertyNames || function getOwnPropertyNames(O) {
  return internalObjectKeys(O, hiddenKeys);
};


/***/ }),

/***/ "x4oI":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var TO_STRING_TAG_SUPPORT = __webpack_require__("WbkG");
var classof = __webpack_require__("r/P8");

// `Object.prototype.toString` method implementation
// https://tc39.github.io/ecma262/#sec-object.prototype.tostring
module.exports = TO_STRING_TAG_SUPPORT ? {}.toString : function toString() {
  return '[object ' + classof(this) + ']';
};


/***/ }),

/***/ "x8Sw":
/***/ (function(module, exports, __webpack_require__) {

var defineWellKnownSymbol = __webpack_require__("tCEB");

// `Symbol.unscopables` well-known symbol
// https://tc39.github.io/ecma262/#sec-symbol.unscopables
defineWellKnownSymbol('unscopables');


/***/ }),

/***/ "xDPO":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("v7GL");
var path = __webpack_require__("j0PW");

var Object = path.Object;

module.exports = function create(P, D) {
  return Object.create(P, D);
};


/***/ }),

/***/ "xQG8":
/***/ (function(module, exports, __webpack_require__) {

var reduce = __webpack_require__("IKC6");

var ArrayPrototype = Array.prototype;

module.exports = function (it) {
  var own = it.reduce;
  return it === ArrayPrototype || (it instanceof Array && own === ArrayPrototype.reduce) ? reduce : own;
};


/***/ }),

/***/ "xR7j":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("n9AK");
var $reduce = __webpack_require__("B6F7").left;
var arrayMethodIsStrict = __webpack_require__("nSCK");
var arrayMethodUsesToLength = __webpack_require__("ocDp");

var STRICT_METHOD = arrayMethodIsStrict('reduce');
var USES_TO_LENGTH = arrayMethodUsesToLength('reduce', { 1: 0 });

// `Array.prototype.reduce` method
// https://tc39.github.io/ecma262/#sec-array.prototype.reduce
$({ target: 'Array', proto: true, forced: !STRICT_METHOD || !USES_TO_LENGTH }, {
  reduce: function reduce(callbackfn /* , initialValue */) {
    return $reduce(this, callbackfn, arguments.length, arguments.length > 1 ? arguments[1] : undefined);
  }
});


/***/ }),

/***/ "xgf2":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("9JhN");
var setGlobal = __webpack_require__("PjRa");

var SHARED = '__core-js_shared__';
var store = global[SHARED] || setGlobal(SHARED, {});

module.exports = store;


/***/ }),

/***/ "xoPw":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("Mkvj");
var entryVirtual = __webpack_require__("Gfq3");

module.exports = entryVirtual('Array').some;


/***/ }),

/***/ "xt6W":
/***/ (function(module, exports, __webpack_require__) {

var classof = __webpack_require__("amH4");

// `IsArray` abstract operation
// https://tc39.github.io/ecma262/#sec-isarray
module.exports = Array.isArray || function isArray(arg) {
  return classof(arg) == 'Array';
};


/***/ }),

/***/ "yC+K":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("9dYR");

/***/ }),

/***/ "yCXr":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("DMYm");
__webpack_require__("X7cO");
__webpack_require__("HXNI");
__webpack_require__("XR+Y");
__webpack_require__("zlYX");
__webpack_require__("Tme5");
__webpack_require__("S9m2");
__webpack_require__("qWJA");
__webpack_require__("32LZ");
__webpack_require__("oKMU");
__webpack_require__("PrcH");
__webpack_require__("N+gJ");
__webpack_require__("KW2q");
__webpack_require__("OcM9");
__webpack_require__("SYdv");
__webpack_require__("jelS");
__webpack_require__("x8Sw");
__webpack_require__("dU17");
__webpack_require__("VPR5");
var path = __webpack_require__("j0PW");

module.exports = path.Symbol;


/***/ }),

/***/ "yFGb":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__("n9AK");
var toAbsoluteIndex = __webpack_require__("Nj2W");
var toInteger = __webpack_require__("lWVH");
var toLength = __webpack_require__("Gpqx");
var toObject = __webpack_require__("quhl");
var arraySpeciesCreate = __webpack_require__("0q0E");
var createProperty = __webpack_require__("1FCb");
var arrayMethodHasSpeciesSupport = __webpack_require__("nB+7");
var arrayMethodUsesToLength = __webpack_require__("ocDp");

var HAS_SPECIES_SUPPORT = arrayMethodHasSpeciesSupport('splice');
var USES_TO_LENGTH = arrayMethodUsesToLength('splice', { ACCESSORS: true, 0: 0, 1: 2 });

var max = Math.max;
var min = Math.min;
var MAX_SAFE_INTEGER = 0x1FFFFFFFFFFFFF;
var MAXIMUM_ALLOWED_LENGTH_EXCEEDED = 'Maximum allowed length exceeded';

// `Array.prototype.splice` method
// https://tc39.github.io/ecma262/#sec-array.prototype.splice
// with adding support of @@species
$({ target: 'Array', proto: true, forced: !HAS_SPECIES_SUPPORT || !USES_TO_LENGTH }, {
  splice: function splice(start, deleteCount /* , ...items */) {
    var O = toObject(this);
    var len = toLength(O.length);
    var actualStart = toAbsoluteIndex(start, len);
    var argumentsLength = arguments.length;
    var insertCount, actualDeleteCount, A, k, from, to;
    if (argumentsLength === 0) {
      insertCount = actualDeleteCount = 0;
    } else if (argumentsLength === 1) {
      insertCount = 0;
      actualDeleteCount = len - actualStart;
    } else {
      insertCount = argumentsLength - 2;
      actualDeleteCount = min(max(toInteger(deleteCount), 0), len - actualStart);
    }
    if (len + insertCount - actualDeleteCount > MAX_SAFE_INTEGER) {
      throw TypeError(MAXIMUM_ALLOWED_LENGTH_EXCEEDED);
    }
    A = arraySpeciesCreate(O, actualDeleteCount);
    for (k = 0; k < actualDeleteCount; k++) {
      from = actualStart + k;
      if (from in O) createProperty(A, k, O[from]);
    }
    A.length = actualDeleteCount;
    if (insertCount < actualDeleteCount) {
      for (k = actualStart; k < len - actualDeleteCount; k++) {
        from = k + actualDeleteCount;
        to = k + insertCount;
        if (from in O) O[to] = O[from];
        else delete O[to];
      }
      for (k = len; k > len - actualDeleteCount + insertCount; k--) delete O[k - 1];
    } else if (insertCount > actualDeleteCount) {
      for (k = len - actualDeleteCount; k > actualStart; k--) {
        from = k + actualDeleteCount - 1;
        to = k + insertCount - 1;
        if (from in O) O[to] = O[from];
        else delete O[to];
      }
    }
    for (k = 0; k < insertCount; k++) {
      O[k + actualStart] = arguments[k + 2];
    }
    O.length = len - actualDeleteCount + insertCount;
    return A;
  }
});


/***/ }),

/***/ "yHq5":
/***/ (function(module, exports, __webpack_require__) {

var parent = __webpack_require__("MYsx");

module.exports = parent;


/***/ }),

/***/ "yRya":
/***/ (function(module, exports, __webpack_require__) {

var has = __webpack_require__("8aeu");
var toIndexedObject = __webpack_require__("N4z3");
var indexOf = __webpack_require__("H17f").indexOf;
var hiddenKeys = __webpack_require__("1odi");

module.exports = function (object, names) {
  var O = toIndexedObject(object);
  var i = 0;
  var result = [];
  var key;
  for (key in O) !has(hiddenKeys, key) && has(O, key) && result.push(key);
  // Don't enum bug & hidden keys
  while (names.length > i) if (has(O, key = names[i++])) {
    ~indexOf(result, key) || result.push(key);
  }
  return result;
};


/***/ }),

/***/ "yULr":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("oNh+");
var setGlobal = __webpack_require__("8x0C");

var SHARED = '__core-js_shared__';
var store = global[SHARED] || setGlobal(SHARED, {});

module.exports = store;


/***/ }),

/***/ "yX36":
/***/ (function(module, exports, __webpack_require__) {

var createNonEnumerableProperty = __webpack_require__("jNzf");

module.exports = function (target, key, value, options) {
  if (options && options.enumerable) target[key] = value;
  else createNonEnumerableProperty(target, key, value);
};


/***/ }),

/***/ "ycY6":
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__("jwue");

__webpack_require__("7x/C");

__webpack_require__("iKE+");

__webpack_require__("KqXw");

__webpack_require__("DZ+c");

__webpack_require__("MvUL");

__webpack_require__("tVqn");

__webpack_require__("+oxZ");

var _trimInstanceProperty = __webpack_require__("LWF0");

var _spliceInstanceProperty = __webpack_require__("L0Na");

var _indexOfInstanceProperty = __webpack_require__("0wSO");

var _typeof = __webpack_require__("p853");

var _parseInt = __webpack_require__("I2Za");

module.exports = {};

module.exports.addZero = function (number) {
  return (_parseInt(number, 10) < 10 ? '0' : '') + number;
};
/* Object.size */


module.exports.size = function (obj) {
  var size = 0,
      key;

  for (key in obj) {
    if (obj.hasOwnProperty(key)) size++;
  }

  return size;
};
/* extend */


module.exports.extend = function () {
  for (var i = 1; i < arguments.length; i++) {
    for (var key in arguments[i]) {
      if (arguments[i].hasOwnProperty(key)) arguments[0][key] = arguments[i][key];
    }
  }

  return arguments[0];
};
/*contains*/


module.exports.contains = function (a, obj) {
  var i = a.length;

  while (i--) {
    if (a[i] === obj) {
      return true;
    }
  }

  return false;
};

module.exports.toCamelCase = function toCamelCase(input) {
  if (_typeof(input) == 'object') {
    var camelCased = {};

    for (var key in input) {
      if (!contains(['parse', '_typeCast'], key)) {
        camelCased[toCamelCase(key)] = input[key];
      }
    }

    return camelCased;
  }

  return input.replace(/[-_](.)/g, function (match, group1) {
    return group1.toUpperCase();
  });
};

module.exports.isArray = function (obj) {
  return Object.prototype.toString.call(obj) === '[object Array]';
};

module.exports.removeValueFromArray = function (arr) {
  var what,
      a = arguments,
      L = a.length,
      ax;

  while (L > 1 && arr.length) {
    what = a[--L];

    while ((ax = _indexOfInstanceProperty(arr).call(arr, what)) !== -1) {
      _spliceInstanceProperty(arr).call(arr, ax, 1);
    }
  }

  return arr;
};

module.exports.unpack = function (encoded) {
  return JSON.parse(encoded);
};

var hasClass = function hasClass(element, cls) {
  var _context;

  return _indexOfInstanceProperty(_context = ' ' + element.className + ' ').call(_context, ' ' + cls + ' ') > -1;
};

var addClass = function addClass(element, className) {
  if (!hasClass(element, className)) element.className = element.className + ' ' + className;
};

var removeClass = function removeClass(element, cls) {
  if (hasClass(element, cls)) {
    var regex = new RegExp(cls, 'g');
    element.className = element.className.replace(regex, '');
  }
};

module.exports.hasClass = hasClass;
module.exports.addClass = addClass;
module.exports.removeClass = removeClass;

module.exports.removeEvent = function (elem, types, eventHandle) {
  if (elem === null || elem === undefined) return;
  if (typeof types == 'string') types = [types];
  forEach(types, function (type) {
    if (elem.removeEventListener) {
      elem.removeEventListener(type, eventHandle, false);
    } else if (elem.detachEvent) {
      elem.detachEvent('on' + type, eventHandle);
    } else {
      elem["on" + type] = null;
    }
  });
};

module.exports.addEvent = function (elem, types, eventHandle) {
  if (elem == null || elem == undefined) return;
  if (typeof types == 'string') types = [types];
  forEach(types, function (type) {
    if (elem.addEventListener) {
      elem.addEventListener(type, eventHandle, false);
    } else if (elem.attachEvent) {
      elem.attachEvent("on" + type, eventHandle);
    } else {
      elem["on" + type] = eventHandle;
    }
  });
};

module.exports.preventDefault = function (event) {
  event.preventDefault ? event.preventDefault() : event.returnValue = false;
};

var getElementsByClassName = module.exports.getElementsByClassName = function (node, classname) {
  if (typeof node == 'string') {
    classname = node;
    node = document;
  }

  var a = [];
  var re = new RegExp('(^| )' + classname + '( |$)');
  var els = node.getElementsByTagName("*");

  for (var i = 0, j = els.length; i < j; i++) {
    if (re.test(els[i].className)) a.push(els[i]);
  }

  return a;
};

var els = module.exports.els = function (node, selector) {
  var _context2;

  if (typeof node == 'string') {
    selector = node;
    node = document;
  }

  var prefix = selector.substr(0, 1);
  if (_indexOfInstanceProperty(_context2 = '.#,').call(_context2, prefix) !== -1) selector = selector.substr(1);
  if (prefix == '.') return getElementsByClassName(node, selector);else if (prefix == '#') {
    var result = node.getElementById(selector);
    if (result) return [result];else return [];
  } else return node.getElementsByTagName(selector);
};

module.exports.el = function (node, selector) {
  var results = els(node, selector);
  return results.length ? results[0] : null;
};
/* previousObject, nextObject, childObject, getChildIndex v0.1 */


var previousObject = function previousObject(elem) {
  elem = elem.previousSibling;

  while (elem && elem.nodeType != 1) {
    elem = elem.previousSibling;
  }

  return elem;
};

module.exports.previousObject = previousObject;

module.exports.nextObject = function (elem) {
  elem = elem.nextSibling;

  while (elem && elem.nodeType != 1) {
    elem = elem.nextSibling;
  }

  return elem;
};

module.exports.childObject = function (elem, index) {
  var i = 0,
      realI = 0;

  while (elem.childNodes[i]) {
    if (elem.childNodes[i].nodeType == 1) {
      if (realI == index) return elem.childNodes[i];
      realI++;
    }

    i++;
  }

  return false;
};

module.exports.getChildIndex = function (child) {
  var i = 0;

  while ((child = previousObject(child)) !== null) {
    i++;
  }

  return i;
};

var forEach = function forEach(array, action) {
  for (var i = 0; i < array.length; i++) {
    action(array[i]);
  }
};

module.exports.forEach = forEach;

module.exports.asymDiff = function (a, b) {
  if (typeof dSuffix != 'string') dSuffix = '';
  var diff = {};

  for (var pName in a) {
    if (typeof b[pName] != 'undefined') {
      if (b[pName] !== a[pName]) diff[pName] = a[pName];
    } else {
      diff[pName] = a[pName];
    }
  }

  return diff;
};

module.exports.arrDiff = function (a, b) {
  var diff = [];

  for (var i = 0; i < a.length; i++) {
    if (_indexOfInstanceProperty(b).call(b, a[i]) == -1) {
      diff.push(a[i]);
    }
  }

  for (i = 0; i < b.length; i++) {
    if (_indexOfInstanceProperty(a).call(a, b[i]) == -1) {
      diff.push(b[i]);
    }
  }

  return diff;
};
/* HTMLElement.prototype.insertAdjacentElement (for FF) */


if (typeof HTMLElement != "undefined" && !HTMLElement.prototype.insertAdjacentElement) {
  HTMLElement.prototype.insertAdjacentElement = function (where, parsedNode) {
    switch (where.toLowerCase()) {
      case 'beforebegin':
        this.parentNode.insertBefore(parsedNode, this);
        break;

      case 'afterbegin':
        this.insertBefore(parsedNode, this.firstChild);
        break;

      case 'beforeend':
        this.appendChild(parsedNode);
        break;

      case 'afterend':
        if (this.nextSibling) this.parentNode.insertBefore(parsedNode, this.nextSibling);else this.parentNode.appendChild(parsedNode);
        break;
    }
  };

  if (!HTMLElement.prototype.insertAdjacentHTML) HTMLElement.prototype.insertAdjacentHTML = function (where, htmlStr) {
    var r = this.ownerDocument.createRange();
    r.setStartBefore(this);
    var parsedHTML = r.createContextualFragment(htmlStr);
    this.insertAdjacentElement(where, parsedHTML);
  };
  if (!HTMLElement.prototype.insertAdjacentText) HTMLElement.prototype.insertAdjacentText = function (where, txtStr) {
    var parsedText = document.createTextNode(txtStr);
    this.insertAdjacentElement(where, parsedText);
  };
}

module.exports.getScrollOffsets = function (w) {
  // Use the specified window or the current window if no argument
  w = w || window; // This works for all browsers except IE versions 8 and before

  if (typeof w.pageXOffset !== 'undefined') return {
    x: w.pageXOffset,
    y: w.pageYOffset
  }; // For IE (or any browser) in Standards mode

  var d = w.document;

  if (document.compatMode == "CSS1Compat") {
    return {
      x: d.documentElement.scrollLeft,
      y: d.documentElement.scrollTop
    };
  } // For browsers in Quirks mode


  return {
    x: d.body.scrollLeft,
    y: d.body.scrollTop
  };
};

module.exports.windowInnerHeight = function (w, d) {
  if (!w) {
    w = window;
    d = document;
  }

  return w.innerHeight || d.documentElement.clientHeight || d.getElementsByTagName('body')[0].clientHeight;
};

module.exports.triggerEvent = function (elem, name) {
  var e;

  if (document.createEvent) {
    e = document.createEvent("HTMLEvents");
    e.initEvent(name, true, true);
  } else {
    e = document.createEventObject();
    e.eventType = name;
  }

  e.eventName = name;

  if (document.createEvent) {
    elem.dispatchEvent(e);
  } else {
    elem.fireEvent("on" + e.eventType, e);
  }
};

module.exports.isElement = function (o) {
  return (typeof HTMLElement === "undefined" ? "undefined" : _typeof(HTMLElement)) === "object" ? o instanceof HTMLElement : //DOM2
  o && _typeof(o) === "object" && o !== null && o.nodeType === 1 && typeof o.nodeName === "string";
}; // add trim function to IE8


if (typeof _trimInstanceProperty(String.prototype) !== 'function') {
  String.prototype.trim = function () {
    return this.replace(/^\s+|\s+$/g, '');
  };
}

module.exports.removeProperty = function (obj, name) {
  if (typeof obj.removeProperty !== 'undefined') return obj.removeProperty(name);
  return obj.removeAttribute(name);
};

/***/ }),

/***/ "ygwS":
/***/ (function(module, exports, __webpack_require__) {

var classof = __webpack_require__("WTd3");

// `IsArray` abstract operation
// https://tc39.github.io/ecma262/#sec-isarray
module.exports = Array.isArray || function isArray(arg) {
  return classof(arg) == 'Array';
};


/***/ }),

/***/ "yk1j":
/***/ (function(module, exports) {

// IE8- don't enum bug keys
module.exports = [
  'constructor',
  'hasOwnProperty',
  'isPrototypeOf',
  'propertyIsEnumerable',
  'toLocaleString',
  'toString',
  'valueOf'
];


/***/ }),

/***/ "z2yT":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("oNh+");
var trim = __webpack_require__("2K/m").trim;
var whitespaces = __webpack_require__("3sPw");

var $parseInt = global.parseInt;
var hex = /^[+-]?0[Xx]/;
var FORCED = $parseInt(whitespaces + '08') !== 8 || $parseInt(whitespaces + '0x16') !== 22;

// `parseInt` method
// https://tc39.github.io/ecma262/#sec-parseint-string-radix
module.exports = FORCED ? function parseInt(string, radix) {
  var S = trim(String(string));
  return $parseInt(S, (radix >>> 0) || (hex.test(S) ? 16 : 10));
} : $parseInt;


/***/ }),

/***/ "zDWZ":
/***/ (function(module, exports, __webpack_require__) {

var bind = __webpack_require__("9X0z");
var IndexedObject = __webpack_require__("fDXD");
var toObject = __webpack_require__("quhl");
var toLength = __webpack_require__("Gpqx");
var arraySpeciesCreate = __webpack_require__("0q0E");

var push = [].push;

// `Array.prototype.{ forEach, map, filter, some, every, find, findIndex }` methods implementation
var createMethod = function (TYPE) {
  var IS_MAP = TYPE == 1;
  var IS_FILTER = TYPE == 2;
  var IS_SOME = TYPE == 3;
  var IS_EVERY = TYPE == 4;
  var IS_FIND_INDEX = TYPE == 6;
  var NO_HOLES = TYPE == 5 || IS_FIND_INDEX;
  return function ($this, callbackfn, that, specificCreate) {
    var O = toObject($this);
    var self = IndexedObject(O);
    var boundFunction = bind(callbackfn, that, 3);
    var length = toLength(self.length);
    var index = 0;
    var create = specificCreate || arraySpeciesCreate;
    var target = IS_MAP ? create($this, length) : IS_FILTER ? create($this, 0) : undefined;
    var value, result;
    for (;length > index; index++) if (NO_HOLES || index in self) {
      value = self[index];
      result = boundFunction(value, index, O);
      if (TYPE) {
        if (IS_MAP) target[index] = result; // map
        else if (result) switch (TYPE) {
          case 3: return true;              // some
          case 5: return value;             // find
          case 6: return index;             // findIndex
          case 2: push.call(target, value); // filter
        } else if (IS_EVERY) return false;  // every
      }
    }
    return IS_FIND_INDEX ? -1 : IS_SOME || IS_EVERY ? IS_EVERY : target;
  };
};

module.exports = {
  // `Array.prototype.forEach` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.foreach
  forEach: createMethod(0),
  // `Array.prototype.map` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.map
  map: createMethod(1),
  // `Array.prototype.filter` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.filter
  filter: createMethod(2),
  // `Array.prototype.some` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.some
  some: createMethod(3),
  // `Array.prototype.every` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.every
  every: createMethod(4),
  // `Array.prototype.find` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.find
  find: createMethod(5),
  // `Array.prototype.findIndex` method
  // https://tc39.github.io/ecma262/#sec-array.prototype.findIndex
  findIndex: createMethod(6)
};


/***/ }),

/***/ "zNvU":
/***/ (function(module, exports) {

var hasOwnProperty = {}.hasOwnProperty;

module.exports = function (it, key) {
  return hasOwnProperty.call(it, key);
};


/***/ }),

/***/ "zc29":
/***/ (function(module, exports, __webpack_require__) {

var NATIVE_WEAK_MAP = __webpack_require__("cpcO");
var global = __webpack_require__("9JhN");
var isObject = __webpack_require__("dSaG");
var createNonEnumerableProperty = __webpack_require__("WxKw");
var objectHas = __webpack_require__("8aeu");
var sharedKey = __webpack_require__("MyxS");
var hiddenKeys = __webpack_require__("1odi");

var WeakMap = global.WeakMap;
var set, get, has;

var enforce = function (it) {
  return has(it) ? get(it) : set(it, {});
};

var getterFor = function (TYPE) {
  return function (it) {
    var state;
    if (!isObject(it) || (state = get(it)).type !== TYPE) {
      throw TypeError('Incompatible receiver, ' + TYPE + ' required');
    } return state;
  };
};

if (NATIVE_WEAK_MAP) {
  var store = new WeakMap();
  var wmget = store.get;
  var wmhas = store.has;
  var wmset = store.set;
  set = function (it, metadata) {
    wmset.call(store, it, metadata);
    return metadata;
  };
  get = function (it) {
    return wmget.call(store, it) || {};
  };
  has = function (it) {
    return wmhas.call(store, it);
  };
} else {
  var STATE = sharedKey('state');
  hiddenKeys[STATE] = true;
  set = function (it, metadata) {
    createNonEnumerableProperty(it, STATE, metadata);
    return metadata;
  };
  get = function (it) {
    return objectHas(it, STATE) ? it[STATE] : {};
  };
  has = function (it) {
    return objectHas(it, STATE);
  };
}

module.exports = {
  set: set,
  get: get,
  has: has,
  enforce: enforce,
  getterFor: getterFor
};


/***/ }),

/***/ "zlYX":
/***/ (function(module, exports) {

// empty


/***/ }),

/***/ "znGZ":
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__("1Mu/");
var fails = __webpack_require__("ct80");
var has = __webpack_require__("8aeu");

var defineProperty = Object.defineProperty;
var cache = {};

var thrower = function (it) { throw it; };

module.exports = function (METHOD_NAME, options) {
  if (has(cache, METHOD_NAME)) return cache[METHOD_NAME];
  if (!options) options = {};
  var method = [][METHOD_NAME];
  var ACCESSORS = has(options, 'ACCESSORS') ? options.ACCESSORS : false;
  var argument0 = has(options, 0) ? options[0] : thrower;
  var argument1 = has(options, 1) ? options[1] : undefined;

  return cache[METHOD_NAME] = !!method && !fails(function () {
    if (ACCESSORS && !DESCRIPTORS) return true;
    var O = { length: -1 };

    if (ACCESSORS) defineProperty(O, 1, { enumerable: true, get: thrower });
    else O[1] = 1;

    method.call(O, argument0, argument1);
  });
};


/***/ })

/******/ });