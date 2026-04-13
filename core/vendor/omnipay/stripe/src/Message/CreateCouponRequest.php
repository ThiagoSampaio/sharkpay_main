ut algorithm as RenderStack but only paints the child
/// specified by index.
///
/// Although only one child is displayed, the cost of the layout algorithm is
/// still O(N), like an ordinary stack.
class RenderIndexedStack extends RenderStack {
  /// Creates a stack render object that paints a single child.
  ///
  /// If the [index] parameter is null, nothing is displayed.
  RenderIndexedStack({
    super.children,
    super.alignment,
    super.textDirection,
    super.fit,
    super.clipBehavior,
    int? index = 0,
  }) : _index = index;

  @override
  void visitChildrenForSemantics(RenderObjectVisitor visitor) {
    final RenderBox? displayedChild = _childAtIndex();
    if (displayedChild != null) {
      visitor(displayedChild);
    }
  }

  /// The index of the child to show, null if nothing is to be displayed.
  int? get index => _index;
  int? _index;
  set index(int? value) {
    if (_index != value) {
      _index = value;
      markNeedsLayout();
    }
  }

  RenderBox? _childAtIndex() {
    final int? index = this.index;
    if (index == null) {
      return null;
    }
    RenderBox? child = firstChild;
    for (int i = 0; i < index && child != null; i += 1) {
      child = childAfter(child);
    }
    assert(firstChild == null || child != null);
    return child;
  }

  @override
  double? computeDistanceToActualBaseline(TextBaseline baseline) {
    final RenderBox? displayedChild = _childAtIndex();
    if (displayedChild == null) {
      return null;
    }
    final StackParentData childParentData = displayedChild.parentData! as StackParentData;
    final BaselineOffset offset =
        BaselineOffset(displayedChild.getDistanceToActualBaseline(baseline)) +
        childParentData.offset.dy;
    return offset.offset;
  }

  @override
  double? computeDryBaseline(BoxConstraints constraints, TextBaseline baseline) {
    final RenderBox? displayedChild = _childAtIndex();
    if (displayedChild == null) {
      return null;
    }
    final BoxConstraints nonPositionedChildConstraints = switch (fit) {
      StackFit.loose => constraints.loosen(),
      StackFit.expand => BoxConstraints.tight(constraints.biggest),
      StackFit.passthrough => constraints,
    };

    final Alignment alignment = _resolvedAlignment;
    final Size size = getDryLayout(constraints);

    return RenderStack._baselineForChild(
      displayedChild,
      size,
      nonPositionedChildConstraints,
      alignment,
      baseline,
    );
  }

  @override
  bool hitTestChildren(BoxHitTestResult result, {required Offset position}) {
    final RenderBox? displayedChild = _childAtIndex();
    if (displayedChild == null) {
      return false;
    }
    final StackParentData childParentData = displayedChild.parentData! as StackParentData;
    return result.addWithPaintOffset(
      offset: childParentData.offset,
      position: position,
      hitTest: (BoxHitTestResult result, Offset transformed) {
        assert(transformed == position - childParentData.offset);
        return displayedChild.hitTest(result, position: transformed);
      },
    );
  }

  @override
  void paintStack(PaintingContext context, Offset offset) {
    final RenderBox? displayedChild = _childAtIndex();
    if (displayedChild == null) {
      return;
    }
    final StackParentData childParentData = displayedChild.parentData! as StackParentData;
    context.paintChild(displayedChild, childParentData.offset + offset);
  }

  @override
  void debugFillProperties(DiagnosticPropertiesBuilder properties) {
    super.debugFillProperties(properties);
    properties.add(IntProperty('index', index));
  }

  @override
  List<DiagnosticsNode> debugDescribeChildren() {
    final List<DiagnosticsNode> children = <DiagnosticsNode>[];
    int i = 0;
    RenderObject? child = firstChild;
    while (child != null) {
      children.add(
        child.toDiagnosticsNode(
          name: 'child ${i + 1}',
          style: i != index ? DiagnosticsTreeStyle.offstage : null,
        ),
      )