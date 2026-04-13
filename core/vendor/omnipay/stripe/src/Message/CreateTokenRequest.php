cheExtent ?? RenderAbstractViewport.defaultCacheExtent,
       _cacheExtentStyle = cacheExtentStyle,
       _clipBehavior = clipBehavior;

  /// Report the semantics of this node, for example for accessibility purposes.
  ///
  /// [RenderViewportBase] adds [RenderViewport.useTwoPaneSemantics] to the
  /// provided [SemanticsConfiguration] to support children using
  /// [RenderViewport.excludeFromScrolling].
  ///
  /// This method should be overridden by subclasses that have interesting
  /// semantic information. Overriding subclasses should call
  /// `super.describeSemanticsConfiguration(config)` to ensure
  /// [RenderViewport.useTwoPaneSemantics] is still added to `config`.
  ///
  /// See also:
  ///
  /// * [RenderObject.describeSemanticsConfiguration], for important
  ///   details about not mutating a [SemanticsConfiguration] out of context.
  @override
  void describeSemanticsConfiguration(SemanticsConfiguration config) {
    super.describeSemanticsConfiguration(config);

    config.addTagForChildren(RenderViewport.useTwoPaneSemantics);
  }

  @override
  void visitChildrenForSemantics(RenderObjectVisitor visitor) {
    childrenInPaintOrder
        .where(
          (RenderSliver sliver) =>
              sliver.geometry!.visible ||
              sliver.geometry!.cacheExtent > 0.0 ||
              sliver.ensureSemantics,
        )
        .forEach(visitor);
  }

  /// The direction in which the [SliverConstraints.scrollOffset] increases.
  ///
  /// For example, if the [axisDirection] is [AxisDirection.down], a scroll
  /// offset of zero is at the top of the viewport and increases towards the
  /// bottom of the viewport.
  AxisDirection get axisDirection => _axisDirection;
  AxisDirection _axisDirection;
  set axisDirection(AxisDirection value) {
    if (value == _axisDirection) {
      return;
    }
    _axisDirection = value;
    markNeedsLayout();
  }

  /// The direction in which child should be laid out in the cross axis.
  ///
  /// For example, if the [axisDirection] is [AxisDirection.down], this property
  /// is typically [AxisDirection.left] if the ambient [TextDirection] is
  /// [TextDirection.rtl] and [AxisDirection.right] if the ambient
  /// [TextDirection] is [TextDirection.ltr].
  AxisDirection get crossAxisDirection => _crossAxisDirection;
  AxisDirection _crossAxisDirection;
  set crossAxisDirection(AxisDirection value) {
    if (value == _crossAxisDirection) {
      return;
    }
    _crossAxisDirection = value;
    markNeedsLayout();
  }

  /// The axis along which the viewport scrolls.
  ///
  /// For example, if the [axisDirection] is [AxisDirection.down], then the
  /// [axis] is [Axis.vertical] and the viewport scrolls vertically.
  Axis get axis => axisDirectionToAxis(axisDirection);

  /// Which part of the content inside the viewport should be visible.
  ///
  /// The [ViewportOffset.pixels] value determines the scroll offset that the
  /// viewport uses to select which part of its content to display. As the user
  /// scrolls the viewport, this value changes, which changes the content that
  /// is displayed.
  ViewportOffset get offset => _offset;
  ViewportOffset _offset;
  set offset(ViewportOffset value) {
    if (value == _offset) {
      return;
    }
    if (attached) {
      _offset.removeListener(markNeedsLayout);
    }
    _offset = value;
    if (attached) {
      _offset.addListener(markNeedsLayout);
    }
    // We need to go through layout even if the new offset has the same pixels
    // value as the old offset so that we will apply our viewport and content
    // dimens