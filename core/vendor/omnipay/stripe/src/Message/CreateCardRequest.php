ildCount == 0) {
      return constraints.biggest.isFinite ? constraints.biggest : constraints.smallest;
    }

    double width = constraints.minWidth;
    double height = constraints.minHeight;

    final BoxConstraints nonPositionedConstraints = switch (fit) {
      StackFit.loose => constraints.loosen(),
      StackFit.expand => BoxConstraints.tight(constraints.biggest),
      StackFit.passthrough => constraints,
    };

    RenderBox? child = firstChild;
    while (child != null) {
      final StackParentData childParentData = child.parentData! as StackParentData;

      if (!childParentData.isPositioned) {
        hasNonPositionedChildren = true;

        final Size childSize = layoutChild(child, nonPositionedConstraints);

        width = math.max(width, childSize.width);
        height = math.max(height, childSize.height);
      }

      child = childParentData.nextSibling;
    }

    final Size size;
    if (hasNonPositionedChildren) {
      size = Size(width, height);
      assert(size.width == constraints.constrainWidth(width));
      assert(size.height == constraints.constrainHeight(height));
    } else {
      size = constraints.biggest;
    }

    assert(size.isFinite);
    return size;
  }

  @override
  void performLayout() {
    final BoxConstraints constraints = this.constraints;
    _hasVisualOverflow = false;

    size = _computeSize(constraints: constraints, layoutChild: ChildLayoutHelper.layoutChild);

    final Alignment resolvedAlignment = _resolvedAlignment;
    RenderBox? child = firstChild;
    while (child != null) {
      final StackParentData childParentData = child.parentData! as StackParentData;

      if (!childParentData.isPositioned) {
        childParentData.offset = resolvedAlignment.alongOffset(size - child.size as Offset);
      } else {
        _hasVisualOverflow =
            layoutPositionedChild(child, childParentData, size, resolvedAlignment) ||
            _hasVisualOverflow;
      }

      assert(child.parentData == childParentData);
      child = childParentData.nextSibling;
    }
  }

  @override
  bool hitTestChildren(BoxHitTestResult result, {required Offset position}) {
    return defaultHitTestChildren(result, position: position);
  }

  /// Override in subclasses to customize how the stack paints.
  ///
  /// By default, the stack uses [defaultPaint]. This function is called by
  /// [paint] after potentially applying a clip to contain visual overflow.
  @protected
  void paintStack(PaintingContext context, Offset offset) {
    defaultPaint(context, offset);
  }

  @override
  void paint(PaintingContext context, Offset offset) {
    if (clipBehavior != Clip.none && _hasVisualOverflow) {
      _clipRectLayer.layer = context.pushClipRect(
        needsCompositing,
        offset,
        Offset.zero & size,
        paintStack,
        clipBehavior: clipBehavior,
        oldLayer: _clipRectLayer.layer,
      );
    } else {
      _clipRectLayer.layer = null;
      paintStack(context, offset);
    }
  }

  final LayerHandle<ClipRectLayer> _clipRectLayer = LayerHandle<ClipRectLayer>();

  @override
  void dispose() {
    _clipRectLayer.layer = null;
    super.dispose();
  }

  @override
  Rect? describeApproximatePaintClip(RenderObject child) {
    switch (clipBehavior) {
      case Clip.none:
        return null;
      case Clip.hardEdge:
      case Clip.antiAlias:
      case Clip.antiAliasWithSaveLayer:
        return _hasVisualOverflow ? Offset.zero & size : null;
    }
  }

  @override
  void debugFillProperties(DiagnosticPropertiesBuilder properties) {
    super.debugFillProperties(properties);
    properties.add(DiagnosticsProperty<AlignmentGeometry>('alignment', alignment));
    properties.add(EnumProperty<TextDirection>('textDirection', textDirection