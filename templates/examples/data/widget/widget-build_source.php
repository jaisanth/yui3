
<ol>
    <li><code>Widget</code> with <code>WidgetStdMod</code>

        <div class="widget-build-example" id="widget1-example">
            <input type="text" id="content" value="">
            <select id="section">
                <option value="header">Header</option>
                <option value="body">Body</option>
                <option value="footer">Footer</option>
            </select>
            <button type="button" id="setContent">Set Content</button>
            <button type="button" class="fail" id="tryMove">move() (should fail)</button>
        
            <div id="widget1">
                <div class="yui-widget-hd">Module Header</div>
                <div class="yui-widget-bd">Module Body</div>
                <div class="yui-widget-ft">Module Footer</div>
            </div>
        
            <p class="filler">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc pretium quam eu mi varius pulvinar. Duis orci arcu, ullamcorper sit amet, luctus ut, interdum ac, quam.</p>
        </div>
    </li>

    <li><code>Widget</code> with <code>WidgetPosition, WidgetStack</code>

        <div class="widget-build-example" id="widget2-example">
            <label>X: <input type="text" id="x" value="0" ></label>
            <label>Y: <input type="text" id="y" value="0" ></label>
            <button type="button" id="move">Move</button>
            <button type="button" class="fail" id="tryContent">setStdModContent() (should fail)</button>

            <div id="widget2"><strong>Positionable Widget</strong></div>

            <p class="filler">
                <select>
                    <option>Prevent IE6 Bleedthrough</option>
                </select>
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc pretium quam eu mi varius pulvinar. Duis orci arcu, ullamcorper sit amet, luctus ut, interdum ac, quam. Pellentesque euismod. Nam tincidunt, purus in ultrices congue, urna neque posuere arcu, aliquam tristique purus sapien id nulla. Etiam rhoncus nulla at leo. Cras scelerisque nisl in nibh. Sed eget odio. Morbi elit elit, porta a, convallis sit amet, rhoncus non, felis. Mauris nulla pede, pretium eleifend, porttitor at, rutrum id, orci. Quisque non urna. Nulla aliquam rhoncus est. 
            </p>
        </div>
    </li>
    
    <li><code>Widget</code> with <code>WidgetPosition, WidgetStack, WidgetPositionExt</code></strong>

        <div class="widget-build-example" id="widget3-example">
            <button type="button" id="run">Run Through Alignment</button>
            <p class="filler">
                <select>
                    <option>Prevent IE6 Bleedthrough</option>
                </select>
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc pretium quam eu mi varius pulvinar. Duis orci arcu, ullamcorper sit amet, luctus ut, interdum ac, quam. Pellentesque euismod. Nam tincidunt, purus in ultrices congue, urna neque posuere arcu, aliquam tristique purus sapien id nulla. Etiam rhoncus nulla at leo. Cras scelerisque nisl in nibh. Sed eget odio. Morbi elit elit, porta a, convallis sit amet, rhoncus non, felis. Mauris nulla pede, pretium eleifend, porttitor at, rutrum id, orci. Quisque non urna. Nulla aliquam rhoncus est.
            </p>
        </div>
    </li>
</ol>


<script type="text/javascript">
YUI(<?php echo $yuiConfig ?>).use(<?php echo $requiredModules ?>, function(Y) {



    // WIDGET 1 : Build Widget with StdMod, but no positioning/stacking support.

    var StandardModule = Y.Base.build(Y.Widget, [Y.WidgetStdMod]);
    StandardModule.NAME = "standardModule";

    var stdmod = new StandardModule({
        contentBox: "#widget1",
        width:"12em",
        height:"12em"
    });
    stdmod.render();

    var contentInput = Y.Node.get("#content");
    var sectionInput = Y.Node.get("#section");

    Y.on("click", function(e) {
        var content = contentInput.get("value");
        var section = sectionInput.get("value");

        stdmod.setStdModContent(section, content);

    }, "#setContent");

    Y.on("click", function(e) {
        try {
            stdmod.move([0,0]);
        } catch (e) {
            alert("move() is " + typeof stdmod.move + ", stdmod.hasImpl(Y.WidgetPosition) : " + stdmod.hasImpl(Y.WidgetPosition));
        }
    }, "#tryMove");



    // WIDGET 2: Build Widget with Position support and Stack support, but no StdMod support or Position Extras support.

    var Positionable = Y.Base.build(Y.Widget, [Y.WidgetPosition, Y.WidgetStack]);
    Positionable.NAME = "positionable";

    var positionable = new Positionable({
        contentBox: "#widget2",
        width:"10em",
        zIndex:1
    });
    positionable.render("#widget2-example");

    var xy = Y.Node.get("#widget2-example > p").getXY();
    positionable.move(xy[0] + 5, xy[1] + 5);

    var xInput = Y.Node.get("#x");
    var yInput = Y.Node.get("#y");

    Y.on("click", function(e) {
        var x = parseInt(xInput.get("value"));
        var y = parseInt(yInput.get("value"));

        positionable.move(x,y);

    }, "#move");

    Y.on("click", function(e) {
        try {
            positionable.setStdModContent("header", "new content");
        } catch (e) {
            alert("setStdModContent() is " + typeof positionable.setStdModContent + ", positionable.hasImpl(Y.WidgetStdMod) : " + positionable.hasImpl(Y.WidgetStdMod));
        }
    }, "#tryContent");



    // WIDGET 3: Build Widget with Position, PositionExt and Stack support, but no StdMod support.

    var Alignable = Y.Base.build(Y.Widget, [Y.WidgetPosition, Y.WidgetPositionExt, Y.WidgetStack]);
    Alignable.NAME = "alignable";

    var alignable = new Alignable({
        width:"10em",
        align : {
            node: "#widget3-example",
            points: ["cc", "cc"]
        },
        zIndex:1
    });
    alignable.get("contentBox").set("innerHTML", '<strong>Alignable Widget</strong><div id="alignment"><p>#widget3-example</p><p>[center, center]</p></div>');
    alignable.render("#widget3-example");

    Y.on('click', function() {
        var stepDelay = 2500;
        var currAlignment = Y.Node.get("#alignment");
        var steps = [
            function() {
                alignable.set("align", {node:"#widget3-example", points:["lc", "rc"]});
                currAlignment.set("innerHTML", "<p>#widget3-example</p><p>[left-center, right-center]</p>");
            },
            function() {
                alignable.set("align", {node:"#widget3-example", points:["tr", "br"]});
                currAlignment.set("innerHTML", "<p>#widget3-example</p><p>[top-right, bottom-right]</p>");
            },
            function() {
                alignable.set("centered", "#widget3-example");
                currAlignment.set("innerHTML", "<p>#widget3-example</p><p>centered</p>");
            },
            function() {
                alignable.set("align", {points:["rc", "rc"]});
                currAlignment.set("innerHTML", "<p>viewport</p><p>[right-center, right-center]</p>");
            },
            function() {
                alignable.set("centered", true);
                currAlignment.set("innerHTML", "<p>viewport</p><p>centered</p>");
            },
            function() {
                alignable.set("align", {node:"#widget3-example", points:["cc", "cc"]});
                currAlignment.set("innerHTML", "<p>#widget3-example</p><p>[center, center]</p>");
            }
        ];
    
        var q = new Y.Queue();
        for (var i = 0; i < steps.length; i++){
            q.add({
                timeout: (i === 0) ? 0 : stepDelay,
                fn:steps[i]
            });
        }
        q.run();
        
    }, "#run");

});
</script>